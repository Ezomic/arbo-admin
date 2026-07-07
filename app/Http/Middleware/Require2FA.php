<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class Require2FA
{
    // This app never stores credentials or a second factor locally — 2FA
    // is entirely Identity's concern, enforced there by its own Require2FA
    // middleware before it will ever mint an SSO token for this app. This
    // middleware is a backstop, not the primary enforcement: it re-sends
    // the session through Identity's SSO handshake once per login, which
    // re-runs Identity's 2FA check, rather than trusting a long-lived
    // local session indefinitely once established. It cannot itself tell
    // whether 2FA is satisfied — the JWT carries no such claim — so a
    // proper fix (a "2fa_verified" claim checked per-request) is tracked
    // as its own follow-up.
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user === null) {
            return $next($request);
        }

        $tenant = Tenant::query()->find($user->tenant_id);

        if (! $tenant?->require_2fa) {
            return $next($request);
        }

        if ($request->session()->get('_2fa_reverified_at') !== null) {
            return $next($request);
        }

        $request->session()->put('_2fa_reverified_at', now()->timestamp);

        $authorizeUrl = config('sso.identity_base_url').'/sso/authorize?'.http_build_query([
            'app' => config('sso.app_slug'),
            'redirect_to' => $request->fullUrl(),
        ]);

        return Inertia::location($authorizeUrl);
    }
}
