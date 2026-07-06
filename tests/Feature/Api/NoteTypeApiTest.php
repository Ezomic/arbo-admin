<?php

use App\Models\ApiClient;
use App\Models\NoteType;
use Illuminate\Support\Str;

test('an authenticated api client can list note types for a tenant and app_slug', function () {
    $client = ApiClient::query()->create(['name' => 'test-client']);
    $token = $client->createToken('test', ['note-types:read'])->plainTextToken;

    $tenantId = (string) Str::uuid();

    $noteType = NoteType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'app_slug' => 'doctors', 'name' => 'Progress note']);
    $noteType->permissions()->create(['role' => 'doctor', 'can_read' => true, 'can_write' => true, 'can_update' => false, 'can_delete' => false]);
    NoteType::withoutGlobalScope('tenant')->create(['tenant_id' => $tenantId, 'app_slug' => 'case-officers', 'name' => 'Other portal note type']);
    NoteType::withoutGlobalScope('tenant')->create(['tenant_id' => (string) Str::uuid(), 'app_slug' => 'doctors', 'name' => 'Other tenant note type']);

    $response = $this->withToken($token)->getJson("/api/note-types?tenant_id={$tenantId}&app_slug=doctors");

    $response->assertOk();
    expect($response->json())->toHaveCount(1)
        ->and($response->json()[0]['name'])->toBe('Progress note')
        ->and($response->json()[0]['permissions'][0]['role'])->toBe('doctor');
});

test('rejects requests without a valid token', function () {
    $this->getJson('/api/note-types?tenant_id='.Str::uuid().'&app_slug=doctors')->assertUnauthorized();
});
