<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NoteType;
use App\Models\NoteTypePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteTypeApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'uuid'],
            'app_slug' => ['required', 'string'],
        ]);

        $noteTypes = NoteType::withoutGlobalScope('tenant')
            ->where('tenant_id', $data['tenant_id'])
            ->where('app_slug', $data['app_slug'])
            ->with('permissions')
            ->oldest()
            ->get()
            ->map(fn (NoteType $nt) => [
                'id' => $nt->id,
                'tenant_id' => $nt->tenant_id,
                'app_slug' => $nt->app_slug,
                'name' => $nt->name,
                'permissions' => $nt->permissions->map(fn (NoteTypePermission $p) => [
                    'id' => $p->id,
                    'role' => $p->role,
                    'can_read' => $p->can_read,
                    'can_write' => $p->can_write,
                    'can_update' => $p->can_update,
                    'can_delete' => $p->can_delete,
                ]),
            ]);

        return response()->json($noteTypes);
    }
}
