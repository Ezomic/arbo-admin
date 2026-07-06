<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

test('index lists users scoped to the acting tenant', function () {
    $tenantId = (string) Str::uuid();
    $user = User::factory()->create(['tenant_id' => $tenantId]);
    $this->actingAs($user);

    Http::fake(['*/api/users*' => Http::response([
        ['id' => (string) Str::uuid(), 'name' => 'Tenant User', 'email' => 'a@b.test', 'user_type_id' => 'arbo', 'role_name' => null, 'scope_id' => null, 'created_at' => now()->toIso8601String()],
    ])]);

    $response = $this->get('/users');

    $response->assertInertia(fn ($page) => $page->component('users/Index')->has('users', 1));

    Http::assertSent(fn ($request) => $request['tenant_id'] === $tenantId);
});

test('store creates a user for the acting tenant', function () {
    $tenantId = (string) Str::uuid();
    $user = User::factory()->create(['tenant_id' => $tenantId]);
    $this->actingAs($user);

    Http::fake(['*/api/users' => Http::response(['id' => (string) Str::uuid(), 'temporary_password' => 'temp-pass'])]);

    $response = $this->post('/users', [
        'name' => 'New Doctor',
        'email' => 'doctor@acme.test',
        'user_type_id' => 'medical_doctor',
    ]);

    $response->assertRedirect(route('users.index'));

    Http::assertSent(function ($request) use ($tenantId) {
        return $request->method() === 'POST'
            && str_ends_with($request->url(), '/api/users')
            && $request['tenant_id'] === $tenantId;
    });
});

test('update sends the acting tenant_id so Identity can enforce isolation', function () {
    $tenantId = (string) Str::uuid();
    $user = User::factory()->create(['tenant_id' => $tenantId]);
    $this->actingAs($user);

    $targetUuid = (string) Str::uuid();
    Http::fake(['*/api/users/*' => Http::response(['id' => $targetUuid])]);

    $response = $this->put("/users/{$targetUuid}", ['name' => 'Renamed']);

    $response->assertRedirect(route('users.index'));

    Http::assertSent(function ($request) use ($tenantId) {
        return $request->method() === 'PUT' && $request['tenant_id'] === $tenantId;
    });
});

test('destroy sends the acting tenant_id so Identity can enforce isolation', function () {
    $tenantId = (string) Str::uuid();
    $user = User::factory()->create(['tenant_id' => $tenantId]);
    $this->actingAs($user);

    $targetUuid = (string) Str::uuid();
    Http::fake(['*/api/users/*' => Http::response([], 204)]);

    $response = $this->delete("/users/{$targetUuid}");

    $response->assertRedirect(route('users.index'));

    Http::assertSent(function ($request) use ($tenantId) {
        return $request->method() === 'DELETE' && $request['tenant_id'] === $tenantId;
    });
});
