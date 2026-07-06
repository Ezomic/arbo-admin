<?php

use App\Models\ContractType;
use App\Models\User;

test('update replaces the allowed case types for a contract type', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $contractType = ContractType::query()->create(['name' => 'Basis', 'is_active' => true]);
    $contractType->caseTypes()->create(['case_type' => 'pmo']);

    $response = $this->put("/contract-types/{$contractType->id}", [
        'name' => 'Basis',
        'is_active' => true,
        'case_types' => ['verzuim', 're_integratie_spoor_1'],
    ]);

    $response->assertRedirect(route('contract-types.index'));

    $enabled = $contractType->caseTypes()->pluck('case_type')->map(fn ($c) => $c->value)->sort()->values()->all();
    expect($enabled)->toBe(['re_integratie_spoor_1', 'verzuim']);
});
