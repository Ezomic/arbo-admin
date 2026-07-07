<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;

test('a user in a tenant without require_2fa reaches gated routes directly', function () {
    $tenant = Tenant::query()->create(['id' => (string) Str::uuid(), 'name' => 'Acme', 'require_2fa' => false]);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $this->actingAs($user)
        ->get(route('contract-types.index'))
        ->assertOk();
});

test('a user in a tenant that requires 2FA is sent through Identity SSO re-verification once per session', function () {
    $tenant = Tenant::query()->create(['id' => (string) Str::uuid(), 'name' => 'Acme', 'require_2fa' => true]);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $response = $this->actingAs($user)->get(route('contract-types.index'));

    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain(config('sso.identity_base_url').'/sso/authorize');
});

test('a user already re-verified this session is not sent through SSO again', function () {
    $tenant = Tenant::query()->create(['id' => (string) Str::uuid(), 'name' => 'Acme', 'require_2fa' => true]);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    session(['_2fa_reverified_at' => now()->timestamp]);

    $this->actingAs($user)
        ->withSession(['_2fa_reverified_at' => now()->timestamp])
        ->get(route('contract-types.index'))
        ->assertOk();
});
