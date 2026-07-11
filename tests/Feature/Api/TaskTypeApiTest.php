<?php

use App\Models\ApiClient;
use App\Models\TaskType;
use Illuminate\Support\Str;

test('an authenticated api client can list active task types for a tenant', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['task-types:read'])->plainTextToken;

    $tenantId = (string) Str::uuid();

    TaskType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'name' => 'Active', 'is_active' => true]);
    TaskType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'name' => 'Inactive', 'is_active' => false]);
    TaskType::withoutGlobalScope('tenant')->create(['tenant_id' => (string) Str::uuid(), 'name' => 'Other Tenant', 'is_active' => true]);

    $response = $this->withToken($token)->getJson('/api/task-types?tenant_id='.$tenantId);

    $response->assertOk();
    expect($response->json())->toHaveCount(1)
        ->and($response->json()[0]['name'])->toBe('Active');
});

test('rejects requests without a valid token', function () {
    $this->getJson('/api/task-types?tenant_id='.Str::uuid())->assertUnauthorized();
});

test('includes conditions in the response payload', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['task-types:read'])->plainTextToken;

    $tenantId = (string) Str::uuid();

    $taskType = TaskType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'name' => 'Plan van aanpak opstellen', 'is_active' => true]);
    $taskType->conditions()->create(['type' => 'case_type', 'case_type' => 'verzuim']);
    $taskType->conditions()->create(['type' => 'milestone_due', 'milestone' => 'plan_van_aanpak']);
    $taskType->conditions()->create(['type' => 'return_date_overdue']);

    $response = $this->withToken($token)->getJson('/api/task-types?tenant_id='.$tenantId);

    $response->assertOk();
    $conditions = collect($response->json()[0]['conditions']);
    expect($conditions)->toHaveCount(3)
        ->and($conditions->firstWhere('type', 'case_type')['case_type'])->toBe('verzuim')
        ->and($conditions->firstWhere('type', 'milestone_due')['milestone'])->toBe('plan_van_aanpak')
        ->and($conditions->contains('type', 'return_date_overdue'))->toBeTrue();
});
