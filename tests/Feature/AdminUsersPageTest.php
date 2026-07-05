<?php

use App\Models\Acheteur;
use App\Models\Producteur;
use App\Models\User;

it('renders the admin users page with dynamic user data', function () {
    $admin = User::factory()->create(['role' => 'acheteur']);

    $producer = User::factory()->create([
        'name' => 'Alice Producer',
        'email' => 'alice@example.com',
        'role' => 'producteur',
    ]);
    Producteur::create([
        'user_id' => $producer->id,
        'localisation' => 'Cotonou',
        'description' => 'Producteur test',
        'piece' => 'CNI.pdf',
        'kycValide' => false,
    ]);

    $buyer = User::factory()->create([
        'name' => 'Bob Buyer',
        'email' => 'bob@example.com',
        'role' => 'acheteur',
    ]);
    Acheteur::create([
        'user_id' => $buyer->id,
        'typeacheteur' => 'particulier',
        'adresseLivraison' => 'Porto-Novo',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.utilisateurs'))
        ->assertOk()
        ->assertSee('Alice Producer')
        ->assertSee('alice@example.com')
        ->assertSee('Cotonou')
        ->assertSee('CNI.pdf')
        ->assertSee('Bob Buyer')
        ->assertSee('Porto-Novo');
});

it('downloads the admin users list as a pdf', function () {
    $admin = User::factory()->create(['role' => 'acheteur']);

    $this->actingAs($admin)
        ->get(route('admin.utilisateurs.export-pdf'))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');
});
