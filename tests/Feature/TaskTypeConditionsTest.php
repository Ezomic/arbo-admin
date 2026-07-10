<?php

use App\Models\TaskType;
use App\Models\User;

test('update replaces the conditions for a task type', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $taskType = TaskType::query()->create(['name' => 'Plan van aanpak opstellen', 'is_active' => true]);
    $taskType->conditions()->create(['type' => 'case_type', 'case_type' => 'pmo']);

    $response = $this->put("/task-types/{$taskType->id}", [
        'name' => 'Plan van aanpak opstellen',
        'is_active' => true,
        'case_type_conditions' => ['verzuim'],
        'milestone_conditions' => ['plan_van_aanpak'],
        'return_date_overdue_condition' => true,
    ]);

    $response->assertRedirect(route('task-types.index'));

    $conditions = $taskType->conditions()->get();
    expect($conditions)->toHaveCount(3)
        ->and($conditions->firstWhere('type', 'case_type')?->case_type?->value)->toBe('verzuim')
        ->and($conditions->firstWhere('type', 'milestone_due')?->milestone?->value)->toBe('plan_van_aanpak')
        ->and($conditions->contains('type', 'return_date_overdue'))->toBeTrue();
});

test('update with nothing checked clears all conditions, leaving the task type manual-only', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $taskType = TaskType::query()->create(['name' => 'Follow-up call', 'is_active' => true]);
    $taskType->conditions()->create(['type' => 'return_date_overdue']);

    $this->put("/task-types/{$taskType->id}", [
        'name' => 'Follow-up call',
        'is_active' => true,
    ])->assertRedirect(route('task-types.index'));

    expect($taskType->conditions()->count())->toBe(0);
});
