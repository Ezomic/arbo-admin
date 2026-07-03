<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * The portals roles/permissions currently exist for — Employees isn't
     * built yet, so there's nothing to define permissions for there.
     *
     * @var array<int, array{slug: string, name: string}>
     */
    private const PORTALS = [
        ['slug' => 'case-officers', 'name' => 'Case Officers'],
        ['slug' => 'employers', 'name' => 'Employers'],
        ['slug' => 'doctors', 'name' => 'Doctors'],
        ['slug' => 'admin', 'name' => 'Admin'],
    ];

    public function index(): Response
    {
        $roles = Role::query()
            ->with('permissions:id')
            ->latest()
            ->get()
            ->map(fn (Role $role) => [
                'id' => $role->id,
                'app_slug' => $role->app_slug,
                'name' => $role->name,
                'description' => $role->description,
                'permission_ids' => $role->permissions->pluck('id'),
            ]);

        return Inertia::render('roles/Index', [
            'portals' => self::PORTALS,
            'roles' => $roles,
            'permissions' => Permission::query()->orderBy('name')->get(['id', 'parent_id', 'app_slug', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $appSlug = $request->validate([
            'app_slug' => ['required', 'string', Rule::in(array_column(self::PORTALS, 'slug'))],
        ])['app_slug'];

        $data = $this->validated($request, $appSlug);

        $role = Role::query()->create([
            'app_slug' => $data['app_slug'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        $role->permissions()->sync($data['permission_ids'] ?? []);

        return to_route('roles.index');
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        // A role's portal is fixed at creation — its permissions all come
        // from that portal's tree, so it can't be reassigned afterwards.
        $data = $this->validated($request, $role->app_slug);

        $role->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        $role->permissions()->sync($data['permission_ids'] ?? []);

        return to_route('roles.index');
    }

    /**
     * @return array{name: string, description: string|null, permission_ids: array<int, string>, app_slug: string}
     */
    private function validated(Request $request, ?string $appSlug): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permission_ids' => ['array'],
            'permission_ids.*' => [
                'uuid',
                Rule::exists('permissions', 'id')->where('app_slug', $appSlug),
            ],
        ]);

        $data['app_slug'] = $appSlug;

        return $data;
    }
}
