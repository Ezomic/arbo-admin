<?php

use App\Models\User;

test('an application_manager can reach a gated management route', function () {
    $user = User::factory()->create(['current_role' => 'application_manager']);

    $this->actingAs($user)
        ->get(route('contract-types.index'))
        ->assertOk();
});

test('a non application_manager authenticated user is rejected from gated management routes', function () {
    $user = User::factory()->create(['current_role' => 'arbo']);

    $this->actingAs($user)
        ->get(route('contract-types.index'))
        ->assertForbidden();
});

test('a guest is redirected to login rather than reaching the gate', function () {
    $this->get(route('contract-types.index'))->assertRedirect(route('login'));
});
