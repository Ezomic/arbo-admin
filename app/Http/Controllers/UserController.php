<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\IdentityClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private const USER_TYPES = ['employer', 'arbo', 'medical_doctor', 'application_manager'];

    public function index(Request $request, IdentityClient $identity): Response
    {
        /** @var User $user */
        $user = $request->user();

        $users = rescue(
            fn () => $identity->getUsers($user->tenant_id, self::USER_TYPES),
            [],
        );

        return Inertia::render('users/Index', [
            'users' => $users,
            'userTypes' => [
                ['id' => 'employer', 'name' => 'Employer contact', 'portal' => 'employers'],
                ['id' => 'arbo', 'name' => 'Case officer', 'portal' => 'case-officers'],
                ['id' => 'medical_doctor', 'name' => 'Medical doctor', 'portal' => 'doctors'],
                ['id' => 'application_manager', 'name' => 'Admin', 'portal' => 'admin'],
            ],
        ]);
    }

    public function store(Request $request, IdentityClient $identity): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'user_type_id' => ['required', 'string', 'in:'.implode(',', self::USER_TYPES)],
            'scope_id' => ['nullable', 'uuid'],
        ]);

        $created = $identity->createUser($user->tenant_id, $data['name'], $data['email'], $data['user_type_id'], $data['scope_id'] ?? null);

        return to_route('users.index')->with('temporaryPassword', $created['temporary_password'] ?? null);
    }

    public function update(Request $request, string $uuid, IdentityClient $identity): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email'],
            'scope_id' => ['sometimes', 'nullable', 'uuid'],
        ]);

        $identity->updateUser($user->tenant_id, $uuid, $data);

        return to_route('users.index');
    }

    public function destroy(Request $request, string $uuid, IdentityClient $identity): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $identity->deleteUser($user->tenant_id, $uuid);

        return to_route('users.index');
    }
}
