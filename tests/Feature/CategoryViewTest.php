<?php

use App\Models\Category;

describe('category pages', function () {
    it('displays categories on the home page', function () {
        Category::create([
            'name' => 'Tubercules',
            'slug' => 'tubercules',
            'icon' => '🥔',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Tubercules');
    });
});
