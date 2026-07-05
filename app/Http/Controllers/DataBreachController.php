<?php

namespace App\Http\Controllers;

use App\Mail\DataBreachAuthorityNotification;
use App\Models\DataBreach;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class DataBreachController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('data-breaches/Index', [
            'breaches' => DataBreach::query()
                ->latest('discovered_at')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('data-breaches/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'discovered_at' => ['required', 'date'],
            'description' => ['required', 'string'],
            'data_categories' => ['required', 'array', 'min:1'],
            'data_categories.*' => ['string'],
            'individuals_affected' => ['nullable', 'integer', 'min:0'],
            'measures_taken' => ['nullable', 'string'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        DataBreach::query()->create([
            ...$data,
            'tenant_id' => $user->tenant_id,
            'reported_by_user_id' => $user->id,
            'status' => 'open',
        ]);

        Inertia::flash('toast', [
            'type' => 'warning',
            'message' => 'Incident logged. Remember: the AP must be notified within 72 hours of discovery.',
        ]);

        return to_route('data-breaches.index');
    }

    public function notify(DataBreach $dataBreach): RedirectResponse
    {
        $authorityEmail = config('services.ap.email');

        abort_if($authorityEmail === null, 500, 'AP_NOTIFICATION_EMAIL is not configured — cannot confirm the authority was notified.');

        Mail::to($authorityEmail)->send(new DataBreachAuthorityNotification($dataBreach));

        $dataBreach->update([
            'status' => 'notified',
            'authority_notified_at' => now(),
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Notification sent to the Autoriteit Persoonsgegevens.',
        ]);

        return back();
    }
}
