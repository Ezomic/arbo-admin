<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolePermissionApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'uuid'],
            'role_name' => ['required', 'string'],
            'app_slug' => ['required', 'string'],
        ]);

        $role = Role::withoutGlobalScope('tenant')
            ->where('tenant_id', $data['tenant_id'])
            ->where('app_slug', $data['app_slug'])
            ->where('name', $data['role_name'])
            ->with('permissions')
            ->first();

        if ($role === null) {
            return response()->json([]);
        }

        $permissions = $role->permissions
            ->whereNotNull('parent_id')
            ->pluck('name')
            ->values();

        return response()->json($permissions);
    }
}
