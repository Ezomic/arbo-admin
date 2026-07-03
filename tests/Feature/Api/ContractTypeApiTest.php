<?php

use App\Models\ApiClient;
use App\Models\ContractType;
use Illuminate\Support\Str;

test('an authenticated api client can list active contract types for a tenant', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['contract-types:read'])->plainTextToken;

    $tenantId = (string) Str::uuid();

    ContractType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'name' => 'Active Type', 'is_active' => true]);
    ContractType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'name' => 'Inactive Type', 'is_active' => false]);
    ContractType::withoutGlobalScope('tenant')->create(['tenant_id' => (string) Str::uuid(), 'name' => 'Other Tenant Type', 'is_active' => true]);

    $response = $this->withToken($token)->getJson('/api/contract-types?tenant_id='.$tenantId);

    $response->assertOk();
    expect($response->json())->toHaveCount(1)
        ->and($response->json()[0]['name'])->toBe('Active Type');
});

test('rejects requests without a valid token', function () {
    $this->getJson('/api/contract-types?tenant_id='.Str::uuid())->assertUnauthorized();
});
