<?php

use App\Models\NoteType;
use App\Models\User;
use Illuminate\Support\Str;

test('store creates a note type with permissions for the acting tenant', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/note-types', [
        'app_slug' => 'doctors',
        'name' => 'Progress note',
        'permissions' => [
            ['role' => 'doctor', 'can_read' => true, 'can_write' => true, 'can_update' => false, 'can_delete' => false],
        ],
    ]);

    $response->assertRedirect(route('note-types.index'));

    $noteType = NoteType::query()->where('name', 'Progress note')->firstOrFail();
    expect($noteType->tenant_id)->toBe($user->tenant_id)
        ->and($noteType->permissions()->where('role', 'doctor')->exists())->toBeTrue();
});

test('a note type from a different tenant is not visible', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    NoteType::withoutGlobalScope('tenant')->create([
        'id' => (string) Str::uuid(),
        'tenant_id' => (string) Str::uuid(),
        'app_slug' => 'doctors',
        'name' => 'Other tenant note type',
    ]);

    $response = $this->get('/note-types');

    $response->assertInertia(fn ($page) => $page->component('note-types/Index')->has('noteTypes', 0));
});

test('update replaces permissions and removes ones no longer sent', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $noteType = NoteType::query()->create(['app_slug' => 'doctors', 'name' => 'Note']);
    $noteType->permissions()->create(['role' => 'doctor', 'can_read' => true, 'can_write' => true, 'can_update' => false, 'can_delete' => false]);

    $response = $this->put("/note-types/{$noteType->id}", [
        'name' => 'Note',
        'permissions' => [
            ['role' => 'senior_doctor', 'can_read' => true, 'can_write' => true, 'can_update' => true, 'can_delete' => true],
        ],
    ]);

    $response->assertRedirect(route('note-types.index'));

    expect($noteType->permissions()->where('role', 'doctor')->exists())->toBeFalse()
        ->and($noteType->permissions()->where('role', 'senior_doctor')->exists())->toBeTrue();
});
