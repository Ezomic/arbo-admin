<?php

use App\Models\ApiClient;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

test('an authenticated api client can list leaf permissions for a tenant role', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['role-permissions:read'])->plainTextToken;

    $tenantId = (string) Str::uuid();

    $parent = Permission::query()->create(['app_slug' => 'case-officers', 'name' => 'View cases']);
    $leaf = Permission::query()->create(['app_slug' => 'case-officers', 'parent_id' => $parent->id, 'name' => 'view-cases']);

    $role = Role::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'app_slug' => 'case-officers', 'name' => 'Case Officer']);
    $role->permissions()->attach([$parent->id, $leaf->id]);

    $response = $this->withToken($token)->getJson("/api/role-permissions?tenant_id={$tenantId}&role_name=Case Officer&app_slug=case-officers");

    $response->assertOk();
    expect($response->json())->toBe(['view-cases']);
});

test('returns an empty array when the role does not exist', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['role-permissions:read'])->plainTextToken;

    $response = $this->withToken($token)->getJson('/api/role-permissions?tenant_id='.Str::uuid().'&role_name=Nope&app_slug=case-officers');

    $response->assertOk();
    expect($response->json())->toBe([]);
});

test('rejects requests without a valid token', function () {
    $this->getJson('/api/role-permissions?tenant_id='.Str::uuid().'&role_name=X&app_slug=case-officers')->assertUnauthorized();
});
