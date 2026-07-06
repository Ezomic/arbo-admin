<?php

namespace App\Http\Controllers;

use App\Models\NoteType;
use App\Models\NoteTypePermission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class NoteTypeController extends Controller
{
    private const PORTALS = [
        ['slug' => 'case-officers', 'name' => 'Case Officers'],
        ['slug' => 'doctors', 'name' => 'Doctors'],
    ];

    public function index(): Response
    {
        $noteTypes = NoteType::query()
            ->with('permissions')
            ->latest()
            ->get()
            ->map(fn (NoteType $nt) => [
                'id' => $nt->id,
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

        $roles = Role::query()
            ->whereIn('app_slug', array_column(self::PORTALS, 'slug'))
            ->get(['id', 'app_slug', 'name']);

        return Inertia::render('note-types/Index', [
            'portals' => self::PORTALS,
            'noteTypes' => $noteTypes,
            'roles' => $roles,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'app_slug' => ['required', 'string', Rule::in(array_column(self::PORTALS, 'slug'))],
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['array'],
            'permissions.*.role' => ['required', 'string', 'max:255'],
            'permissions.*.can_read' => ['boolean'],
            'permissions.*.can_write' => ['boolean'],
            'permissions.*.can_update' => ['boolean'],
            'permissions.*.can_delete' => ['boolean'],
        ]);

        $noteType = NoteType::query()->create([
            'app_slug' => $data['app_slug'],
            'name' => $data['name'],
        ]);

        foreach ($data['permissions'] ?? [] as $perm) {
            $noteType->permissions()->create($perm);
        }

        return to_route('note-types.index');
    }

    public function update(Request $request, NoteType $noteType): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['array'],
            'permissions.*.role' => ['required', 'string', 'max:255'],
            'permissions.*.can_read' => ['boolean'],
            'permissions.*.can_write' => ['boolean'],
            'permissions.*.can_update' => ['boolean'],
            'permissions.*.can_delete' => ['boolean'],
        ]);

        $noteType->update(['name' => $data['name']]);

        /** @var array<int, array<string, mixed>> $permissions */
        $permissions = $data['permissions'] ?? [];
        $incoming = collect($permissions);
        $existingByRole = $noteType->permissions->keyBy('role');

        foreach ($incoming as $perm) {
            if ($existingByRole->has($perm['role'])) {
                $existingByRole[$perm['role']]->update($perm);
            } else {
                $noteType->permissions()->create($perm);
            }
        }

        $incomingRoles = $incoming->pluck('role')->all();
        $noteType->permissions()->whereNotIn('role', $incomingRoles)->delete();

        return to_route('note-types.index');
    }

    public function destroy(NoteType $noteType): RedirectResponse
    {
        $noteType->delete();

        return to_route('note-types.index');
    }
}
