<?php

use App\Models\User;

describe('Panier page', function () {
    it('renders the cart page even when the user has no cart yet', function () {
        $user = User::factory()->create(['role' => 'acheteur']);

        $this->actingAs($user);

        $this->get(route('panier'))
            ->assertOk()
            ->assertSee('Panier vide');
    });
});
