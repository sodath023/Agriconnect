<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::firstOrCreate(
            ['slug' => 'tubercules'],
            [
                'name' => 'Tubercules',
                'icon' => '🥔',
                'description' => 'Igname, Patate douce, Manioc',
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'cereales'],
            [
                'name' => 'Céréales',
                'icon' => '🌽',
                'description' => 'Maïs, Riz local, Sorgho',
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'legumineuses'],
            [
                'name' => 'Légumineuses',
                'icon' => '🫘',
                'description' => 'Haricots, Arachides, Soja',
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'legumes-frais'],
            [
                'name' => 'Légumes Frais',
                'icon' => '🥬',
                'description' => 'Tomate, Oignon, Piment',
            ]
        );

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
