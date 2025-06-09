<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Gelir Kategorileri
            ['name' => 'Maaş', 'type' => 'income', 'color' => '#2ecc71'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#27ae60'],
            ['name' => 'Yatırım', 'type' => 'income', 'color' => '#f39c12'],
            ['name' => 'Diğer Gelir', 'type' => 'income', 'color' => '#3498db'],

            // Gider Kategorileri
            ['name' => 'Yiyecek', 'type' => 'expense', 'color' => '#e74c3c'],
            ['name' => 'Ulaşım', 'type' => 'expense', 'color' => '#9b59b6'],
            ['name' => 'Barınma', 'type' => 'expense', 'color' => '#34495e'],
            ['name' => 'Sağlık', 'type' => 'expense', 'color' => '#e67e22'],
            ['name' => 'Eğlence', 'type' => 'expense', 'color' => '#f1c40f'],
            ['name' => 'Yakıt', 'type' => 'expense', 'color' => '#95a5a6'],
            ['name' => 'Diğer Gider', 'type' => 'expense', 'color' => '#7f8c8d'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
