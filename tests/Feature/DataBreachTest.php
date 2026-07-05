<?php

use App\Mail\DataBreachAuthorityNotification;
use App\Models\DataBreach;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('reporting an incident logs it scoped to the reporting user\'s tenant', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/data-breaches', [
        'discovered_at' => now()->toDateTimeString(),
        'description' => 'Laptop with employee records stolen',
        'data_categories' => ['NAW-gegevens', 'Gezondheidsgegevens'],
        'individuals_affected' => 12,
    ]);

    $response->assertRedirect(route('data-breaches.index'));

    $breach = DataBreach::query()->where('description', 'Laptop with employee records stolen')->firstOrFail();
    expect($breach->tenant_id)->toBe($user->tenant_id)
        ->and($breach->reported_by_user_id)->toBe($user->id)
        ->and($breach->status)->toBe('open');
});

test('notifying the AP sends the mail and marks the breach as notified', function () {
    config(['services.ap.email' => 'meldpunt@autoriteitpersoonsgegevens.nl']);
    Mail::fake();

    $user = User::factory()->create();
    $breach = DataBreach::query()->create([
        'tenant_id' => $user->tenant_id,
        'reported_by_user_id' => $user->id,
        'discovered_at' => now(),
        'description' => 'Incident',
        'data_categories' => ['NAW-gegevens'],
        'status' => 'open',
    ]);

    $response = $this->actingAs($user)->patch("/data-breaches/{$breach->id}/notify");

    $response->assertRedirect();
    Mail::assertSent(DataBreachAuthorityNotification::class, fn ($mail) => $mail->hasTo('meldpunt@autoriteitpersoonsgegevens.nl') && $mail->breach->is($breach));

    expect($breach->refresh()->status)->toBe('notified')
        ->and($breach->authority_notified_at)->not->toBeNull();
});

test('notifying the AP fails loudly instead of falsely claiming success when no address is configured', function () {
    config(['services.ap.email' => null]);
    Mail::fake();

    $user = User::factory()->create();
    $breach = DataBreach::query()->create([
        'tenant_id' => $user->tenant_id,
        'reported_by_user_id' => $user->id,
        'discovered_at' => now(),
        'description' => 'Incident',
        'data_categories' => ['NAW-gegevens'],
        'status' => 'open',
    ]);

    $this->actingAs($user)->patch("/data-breaches/{$breach->id}/notify")->assertStatus(500);

    Mail::assertNothingSent();
    expect($breach->refresh()->status)->toBe('open');
});
