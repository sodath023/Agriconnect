<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('authenticates a user when the phone number is entered with spaces', function () {
    $user = User::factory()->create([
        'name' => 'Producteur Test',
        'email' => 'producteur@example.com',
        'telephone' => '97000000',
        'role' => 'producteur',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/connexion', [
        'identifier' => '97 00 00 00',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/dashboard-producteur');
    $this->assertAuthenticatedAs($user);
});
