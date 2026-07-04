<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskType;
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
            ->oldest()
            ->get()
            ->map(fn (TaskType $tt) => [
                'id' => $tt->id,
                'tenant_id' => $tt->tenant_id,
                'name' => $tt->name,
                'description' => $tt->description,
            ]);

        return response()->json($taskTypes);
    }
}
