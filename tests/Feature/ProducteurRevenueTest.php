<?php

use App\Models\User;

describe('Producteur revenues page', function () {
    it('renders the revenue page for a producteur without products', function () {
        $user = User::factory()->create(['role' => 'producteur']);

        $this->actingAs($user);

        $this->get(route('producteur.mes-revenus'))
            ->assertOk();
    });
});
