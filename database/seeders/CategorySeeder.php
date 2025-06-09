<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income Categories
            ['name' => 'Salary', 'type' => 'income', 'description' => 'Monthly salary income'],
            ['name' => 'Freelance', 'type' => 'income', 'description' => 'Freelance work income'],
            ['name' => 'Investments', 'type' => 'income', 'description' => 'Investment returns'],
            ['name' => 'Gifts', 'type' => 'income', 'description' => 'Gift money received'],
            ['name' => 'Other Income', 'type' => 'income', 'description' => 'Other sources of income'],

            // Expense Categories
            ['name' => 'Housing', 'type' => 'expense', 'description' => 'Rent, mortgage, utilities'],
            ['name' => 'Food', 'type' => 'expense', 'description' => 'Groceries and dining out'],
            ['name' => 'Transportation', 'type' => 'expense', 'description' => 'Gas, public transport, car maintenance'],
            ['name' => 'Entertainment', 'type' => 'expense', 'description' => 'Movies, games, hobbies'],
            ['name' => 'Shopping', 'type' => 'expense', 'description' => 'Clothes, electronics, etc.'],
            ['name' => 'Healthcare', 'type' => 'expense', 'description' => 'Medical expenses, insurance'],
            ['name' => 'Education', 'type' => 'expense', 'description' => 'Tuition, books, courses'],
            ['name' => 'Bills', 'type' => 'expense', 'description' => 'Phone, internet, subscriptions'],
            ['name' => 'Travel', 'type' => 'expense', 'description' => 'Vacations and trips'],
            ['name' => 'Other Expenses', 'type' => 'expense', 'description' => 'Miscellaneous expenses'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
