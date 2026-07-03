<?php

use App\Http\Controllers\Api\ContractTypeApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api-client', 'throttle:60,1'])->group(function () {
    Route::get('contract-types', [ContractTypeApiController::class, 'index'])
        ->middleware('ability:contract-types:read');
});
