<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Services\IdentityClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TenantSettingsController extends Controller
{
    public function show(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $tenant = Tenant::where('id', $user->tenant_id)->first();

        return Inertia::render('tenant-settings/Show', [
            'require2fa' => $tenant === null ? false : $tenant->require_2fa,
        ]);
    }

    public function update(Request $request, IdentityClient $identity): RedirectResponse
    {
        $data = $request->validate([
            'require_2fa' => ['required', 'boolean'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $identity->updateTenant($user->tenant_id, $data['require_2fa']);

        Tenant::query()->where('id', $user->tenant_id)->update(['require_2fa' => $data['require_2fa']]);

        return to_route('tenant-settings.show');
    }
}
