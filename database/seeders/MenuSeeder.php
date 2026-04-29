<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Snacks' => [
                ['name' => 'French Fries', 'price' => 55000],
                ['name' => 'Banana Fritter', 'price' => 55000],
                ['name' => 'Mix Platter', 'price' => 70000],
                ['name' => 'Chicken Wings', 'price' => 55000],
                ['name' => 'Calamari Ring', 'price' => 60000],
            ],
            'Soups' => [
                ['name' => 'Chicken Corn Soup', 'price' => 50000],
                ['name' => 'Soto Pamekasan', 'price' => 75000],
                ['name' => 'Soto Betawi', 'price' => 85000],
            ],
            'Pasta Signature' => [
                ['name' => 'Pasta Carbonara', 'price' => 75000],
                ['name' => 'Pasta Aglio e Olio', 'price' => 75000],
                ['name' => 'Pasta Bolognaise', 'price' => 75000],
            ],
            'Main Course' => [
                ['name' => 'Amanuba Fried Rice', 'price' => 95000],
                ['name' => 'Traditional Fried Rice', 'price' => 80000],
                ['name' => 'Oriental Fried Rice', 'price' => 75000],
                ['name' => 'Seafood Fried Rice', 'price' => 75000],
                ['name' => 'Noodles/Rice Noodles/Kwetiau', 'price' => 65000],
            ],
        ];

        foreach ($data as $categoryName => $menus) {
            $category = Category::updateOrCreate(['name' => $categoryName]);

            foreach ($menus as $menuData) {
                Menu::updateOrCreate(
                    ['name' => $menuData['name']],
                    [
                        'price' => $menuData['price'],
                        'category_id' => $category->id,
                        'description' => $menuData['name'] . ' ala Amanuba Resort'
                    ]
                );
            }
        }
    }
}
