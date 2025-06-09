<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        $categoryId = $request->input('category_id');
        $type = $request->input('type');

        $query = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->whereBetween('transaction_date', [$startDate, $endDate]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $transactions = $query->get();

        // Calculate summary statistics
        $summary = [
            'total_income' => $transactions->where('type', 'income')->sum('amount'),
            'total_expenses' => $transactions->where('type', 'expense')->sum('amount'),
            'net_balance' => $transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount'),
            'average_income' => $transactions->where('type', 'income')->avg('amount'),
            'average_expense' => $transactions->where('type', 'expense')->avg('amount'),
            'max_income' => $transactions->where('type', 'income')->max('amount'),
            'max_expense' => $transactions->where('type', 'expense')->max('amount'),
        ];

        // Get category-wise summary
        $categorySummary = $transactions->groupBy('category_id')
            ->map(function ($items) {
                return [
                    'category' => $items->first()->category->name,
                    'total' => $items->sum('amount'),
                    'count' => $items->count(),
                    'average' => $items->avg('amount'),
                ];
            });

        $categories = Category::all();

        return view('reports.index', compact(
            'transactions',
            'summary',
            'categorySummary',
            'categories',
            'startDate',
            'endDate',
            'categoryId',
            'type'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        $categoryId = $request->input('category_id');
        $type = $request->input('type');

        $query = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->whereBetween('transaction_date', [$startDate, $endDate]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $transactions = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions.csv"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Date', 'Category', 'Type', 'Amount', 'Description']);

            // Add data
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_date->format('Y-m-d'),
                    $transaction->category->name,
                    $transaction->type,
                    $transaction->amount,
                    $transaction->description
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
