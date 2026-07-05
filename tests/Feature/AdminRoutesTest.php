<?php

use App\Models\User;

describe('Admin routes', function () {
    it('renders the admin pages for authenticated users', function () {
        $user = new User([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->id = 1;

        $this->actingAs($user);

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.moderation'))->assertOk();
        $this->get(route('admin.parametres'))->assertOk();
        $this->get(route('admin.utilisateurs'))->assertOk();
    });

    it('redirects legacy admin urls to the current admin pages', function () {
        $user = new User([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->id = 1;

        $this->actingAs($user);

        $this->get('/admin-dashboard.html')->assertRedirect(route('admin.dashboard'));
        $this->get('/admin-moderation.html')->assertRedirect(route('admin.moderation'));
        $this->get('/admin-parametres.html')->assertRedirect(route('admin.parametres'));
        $this->get('/admin-utilisateurs.html')->assertRedirect(route('admin.utilisateurs'));
    });
});
