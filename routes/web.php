<?php

use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskTypeController;
use Illuminate\Support\Facades\Route;
use RobbinThijssen\IdentitySsoKit\Http\Controllers\LogoutController;
use RobbinThijssen\IdentitySsoKit\Http\Controllers\RedirectToIdentityController;
use RobbinThijssen\IdentitySsoKit\Http\Controllers\SsoCallbackController;

Route::get('login', RedirectToIdentityController::class)->name('login');
Route::get('sso/callback', SsoCallbackController::class)->name('sso.callback');
Route::post('logout', LogoutController::class)->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::redirect('/', '/contract-types')->name('home');
    Route::redirect('dashboard', '/contract-types')->name('dashboard');

    Route::get('contract-types', [ContractTypeController::class, 'index'])->name('contract-types.index');
    Route::post('contract-types', [ContractTypeController::class, 'store'])->name('contract-types.store');
    Route::put('contract-types/{contractType}', [ContractTypeController::class, 'update'])->name('contract-types.update');

    Route::get('task-types', [TaskTypeController::class, 'index'])->name('task-types.index');
    Route::post('task-types', [TaskTypeController::class, 'store'])->name('task-types.store');
    Route::put('task-types/{taskType}', [TaskTypeController::class, 'update'])->name('task-types.update');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
});

require __DIR__.'/settings.php';
