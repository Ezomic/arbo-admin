<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

test('show reflects the tenant require_2fa flag via the tenant relation', function () {
    $tenant = Tenant::query()->create(['id' => (string) Str::uuid(), 'name' => 'Acme', 'require_2fa' => true]);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);
    $this->actingAs($user)->withSession(['_2fa_reverified_at' => now()->timestamp]);

    $response = $this->get(route('tenant-settings.show'));

    $response->assertInertia(fn ($page) => $page->component('tenant-settings/Show')->where('require2fa', true));
});

test('show defaults to false when the tenant has not synced locally yet', function () {
    $user = User::factory()->create(['tenant_id' => (string) Str::uuid()]);
    $this->actingAs($user);

    $response = $this->get(route('tenant-settings.show'));

    $response->assertInertia(fn ($page) => $page->component('tenant-settings/Show')->where('require2fa', false));
});

test('update pushes require_2fa to Identity and updates the local tenant record', function () {
    $tenant = Tenant::query()->create(['id' => (string) Str::uuid(), 'name' => 'Acme', 'require_2fa' => false]);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);
    $this->actingAs($user);

    Http::fake(['*/api/tenants/*' => Http::response(['id' => $tenant->id, 'require_2fa' => true])]);

    $response = $this->put(route('tenant-settings.update'), ['require_2fa' => true]);

    $response->assertRedirect(route('tenant-settings.show'));
    expect($tenant->fresh()->require_2fa)->toBeTrue();
});
