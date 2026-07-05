<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\commande;

it('renders the admin dashboard with dynamic metrics', function () {
    $admin = User::factory()->create(['role' => 'administrateur']);

    User::factory()->count(2)->create(['role' => 'producteur']);
    User::factory()->count(3)->create(['role' => 'acheteur']);

    $category = Category::create(['name' => 'Légumes', 'slug' => 'legumes']);
    $producer = User::factory()->create(['role' => 'producteur']);
    Product::create([
        'user_id' => $producer->id,
        'category_id' => $category->id,
        'nom' => 'Produit A',
        'description' => 'Description',
        'prix' => 1000,
        'stock' => 10,
        'unite' => 'kg',
        'image' => 'products/default.jpg',
        'latitude' => 6.35,
        'longitude' => 1.23,
        'statut' => 'valide',
    ]);
    Product::create([
        'user_id' => $producer->id,
        'category_id' => $category->id,
        'nom' => 'Produit B',
        'description' => 'Description',
        'prix' => 2000,
        'stock' => 5,
        'unite' => 'kg',
        'image' => 'products/default.jpg',
        'latitude' => 6.35,
        'longitude' => 1.23,
        'statut' => 'valide',
    ]);
    Product::create([
        'user_id' => $producer->id,
        'category_id' => $category->id,
        'nom' => 'Produit C',
        'description' => 'Description',
        'prix' => 1500,
        'stock' => 7,
        'unite' => 'kg',
        'image' => 'products/default.jpg',
        'latitude' => 6.35,
        'longitude' => 1.23,
        'statut' => 'en_attente',
    ]);

    commande::create([
        'reference' => 'CMD-001',
        'firstname' => 'Test',
        'lastname' => 'User',
        'email' => 'test@example.com',
        'phone' => '00000000',
        'address' => 'Address',
        'city' => 'Cotonou',
        'subtotal' => 10000,
        'shipping_fee' => 1500,
        'total' => 11500,
        'status' => 'paid',
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Tableau de bord Administrateur');
});
