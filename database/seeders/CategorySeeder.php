<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tubercules (Igname, Patate)'],
            ['name' => 'Céréales (Maïs, Riz)'],
            ['name' => 'Légumineuses (Haricot, Pois)'],
            ['name' => 'Fruits (Mangue, Ananas)'],
            ['name' => 'Légumes (Tomate, Piment)'],
            ['name' => 'Produits laitiers (Lait, Fromage)'],
            ['name' => 'Viandes (Bœuf, Poulet)'],
            ['name' => 'Poissons et fruits de mer'],
            ['name' => 'Épices et herbes aromatiques'],
            ['name' => 'Boissons (Jus, Thé)'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
