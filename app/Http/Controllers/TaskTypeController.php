<?php

namespace App\Http\Controllers;

use App\Models\TaskType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return Inertia::render('task-types/Edit', [
            'taskType' => $taskType,
        ]);
    }

    public function update(Request $request, TaskType $taskType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $taskType->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Task type updated.']);

        return to_route('task-types.index');
    }
}
