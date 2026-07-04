<?php

use App\Http\Controllers\Api\ContractTypeApiController;
use App\Http\Controllers\Api\NoteTypeApiController;
use App\Http\Controllers\Api\RolePermissionApiController;
use App\Http\Controllers\Api\TaskTypeApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api-client', 'throttle:api-client'])->group(function () {
    Route::get('contract-types', [ContractTypeApiController::class, 'index'])
        ->middleware('ability:contract-types:read');

    Route::get('note-types', [NoteTypeApiController::class, 'index'])
        ->middleware('ability:note-types:read');

    Route::get('task-types', [TaskTypeApiController::class, 'index'])
        ->middleware('ability:task-types:read');

    Route::get('role-permissions', [RolePermissionApiController::class, 'index'])
        ->middleware('ability:role-permissions:read');
});
