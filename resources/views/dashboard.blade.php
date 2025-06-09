<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Income Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Income</div>
                        <div class="mt-2 text-3xl font-semibold text-green-600">{{ number_format($monthlyIncome, 2) }}</div>
                    </div>
                </div>

                <!-- Expenses Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Expenses</div>
                        <div class="mt-2 text-3xl font-semibold text-red-600">{{ number_format($monthlyExpenses, 2) }}</div>
                    </div>
                </div>

                <!-- Balance Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Balance</div>
                        <div class="mt-2 text-3xl font-semibold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($balance, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Transactions</h3>
                        <div class="space-y-4">
                            @foreach($recentTransactions as $transaction)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $transaction->category->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->transaction_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="text-sm font-medium {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category Expenses -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Expenses by Category</h3>
                        <div class="space-y-4">
                            @foreach($categoryExpenses as $expense)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $expense->category->name }}
                                        </div>
                                        <div class="text-sm font-medium text-red-600">
                                            {{ number_format($expense->total, 2) }}
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($expense->total / $monthlyExpenses) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Monthly Trend</h3>
                    <div class="h-64">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
            
            // Prepare data for the chart
            const months = {!! json_encode($monthlyTrend->pluck('month')->unique()) !!};
            const incomeData = {!! json_encode($monthlyTrend->where('type', 'income')->pluck('total')) !!};
            const expenseData = {!! json_encode($monthlyTrend->where('type', 'expense')->pluck('total')) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months.map(month => {
                        const date = new Date();
                        date.setMonth(month - 1);
                        return date.toLocaleString('default', { month: 'short' });
                    }),
                    datasets: [
                        {
                            label: 'Income',
                            data: incomeData,
                            borderColor: 'rgb(34, 197, 94)',
                            tension: 0.1
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: 'rgb(239, 68, 68)',
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
