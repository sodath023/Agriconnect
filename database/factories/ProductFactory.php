<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'producteur'])->id,
            'category_id' => 1,
            'nom' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'prix' => $this->faker->numberBetween(1000, 50000),
            'stock' => $this->faker->numberBetween(5, 50),
            'unite' => 'kg',
            'image' => 'products/default.jpg',
            'latitude' => 6.35,
            'longitude' => 1.23,
            'statut' => 'valide',
        ];
    }
}
