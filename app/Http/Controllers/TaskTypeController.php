<?php

namespace App\Http\Controllers;

use App\Enums\CaseType;
use App\Enums\ReintegrationMilestone;
use App\Models\TaskType;
use App\Models\TaskTypeCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class TaskTypeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('task-types/Index', [
            'taskTypes' => TaskType::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        TaskType::query()->create($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Task type created.']);

        return to_route('task-types.index');
    }

    public function edit(TaskType $taskType): Response
    {
        $conditions = $taskType->conditions()->get();

        return Inertia::render('task-types/Edit', [
            'taskType' => $taskType,
            'caseTypeOptions' => array_map(
                fn (CaseType $t) => ['value' => $t->value, 'label' => $t->label()],
                CaseType::cases(),
            ),
            'milestoneOptions' => array_map(
                fn (ReintegrationMilestone $m) => ['value' => $m->value, 'label' => $m->label()],
                ReintegrationMilestone::cases(),
            ),
            'enabledCaseTypes' => $conditions->where('type', 'case_type')->pluck('case_type')->all(),
            'enabledMilestones' => $conditions->where('type', 'milestone_due')->pluck('milestone')->all(),
            'returnDateOverdueEnabled' => $conditions->contains('type', 'return_date_overdue'),
        ]);
    }

    public function update(Request $request, TaskType $taskType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'case_type_conditions' => ['array'],
            'case_type_conditions.*' => [Rule::enum(CaseType::class)],
            'milestone_conditions' => ['array'],
            'milestone_conditions.*' => [Rule::enum(ReintegrationMilestone::class)],
            'return_date_overdue_condition' => ['boolean'],
        ]);

        $taskType->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? $taskType->is_active,
        ]);

        $taskType->conditions()->delete();

        foreach ($data['case_type_conditions'] ?? [] as $caseType) {
            TaskTypeCondition::query()->create([
                'task_type_id' => $taskType->id,
                'type' => 'case_type',
                'case_type' => $caseType,
            ]);
        }

        foreach ($data['milestone_conditions'] ?? [] as $milestone) {
            TaskTypeCondition::query()->create([
                'task_type_id' => $taskType->id,
                'type' => 'milestone_due',
                'milestone' => $milestone,
            ]);
        }

        if ($data['return_date_overdue_condition'] ?? false) {
            TaskTypeCondition::query()->create([
                'task_type_id' => $taskType->id,
                'type' => 'return_date_overdue',
            ]);
        }

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Task type updated.']);

        return to_route('task-types.index');
    }
}
