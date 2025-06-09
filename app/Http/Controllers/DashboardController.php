<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get date range for the current month
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        // Get total income and expenses for the current month
        $monthlySummary = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->select(
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expenses')
            )
            ->first();

        // Get category-wise summary for the current month
        $categorySummary = Transaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                'transactions.type',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('categories.name', 'transactions.type')
            ->get();

        // Get recent transactions
        $recentTransactions = Transaction::with('category')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        // Get monthly trend data for the last 6 months
        $monthlyTrend = Transaction::where('transaction_date', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for charts
        $chartData = [
            'labels' => $monthlyTrend->pluck('month'),
            'income' => $monthlyTrend->pluck('income'),
            'expenses' => $monthlyTrend->pluck('expenses'),
        ];

        // Calculate net balance
        $netBalance = ($monthlySummary->total_income ?? 0) - ($monthlySummary->total_expenses ?? 0);

        return view('dashboard', compact(
            'monthlySummary',
            'categorySummary',
            'recentTransactions',
            'chartData',
            'netBalance'
        ));
    }
}
