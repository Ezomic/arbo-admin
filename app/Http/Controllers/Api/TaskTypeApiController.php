<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskType;
use App\Models\TaskTypeCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskTypeApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'uuid'],
        ]);

        $taskTypes = TaskType::withoutGlobalScope('tenant')
            ->where('tenant_id', $data['tenant_id'])
            ->where('is_active', true)
            ->with('conditions')
            ->oldest()
            ->get()
            ->map(fn (TaskType $tt) => [
                'id' => $tt->id,
                'tenant_id' => $tt->tenant_id,
                'name' => $tt->name,
                'description' => $tt->description,
                'conditions' => $this->serializeConditions($tt),
            ]);

        return response()->json($taskTypes);
    }

    /** @return array<int, array{type: string, case_type: string|null, milestone: string|null}> */
    private function serializeConditions(TaskType $taskType): array
    {
        return $taskType->conditions
            ->map(fn (TaskTypeCondition $c) => [
                'type' => $c->type,
                'case_type' => $c->case_type?->value,
                'milestone' => $c->milestone?->value,
            ])
            ->all();
    }
}
