<?php

use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\DataBreachController;
use App\Http\Controllers\NoteTypeController;
use App\Http\Controllers\UserController;
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
    Route::get('contract-types/{contractType}/edit', [ContractTypeController::class, 'edit'])->name('contract-types.edit');
    Route::put('contract-types/{contractType}', [ContractTypeController::class, 'update'])->name('contract-types.update');

    Route::get('task-types', [TaskTypeController::class, 'index'])->name('task-types.index');
    Route::post('task-types', [TaskTypeController::class, 'store'])->name('task-types.store');
    Route::get('task-types/{taskType}/edit', [TaskTypeController::class, 'edit'])->name('task-types.edit');
    Route::put('task-types/{taskType}', [TaskTypeController::class, 'update'])->name('task-types.update');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('data-breaches', [DataBreachController::class, 'index'])->name('data-breaches.index');
    Route::get('data-breaches/create', [DataBreachController::class, 'create'])->name('data-breaches.create');
    Route::post('data-breaches', [DataBreachController::class, 'store'])->name('data-breaches.store');
    Route::patch('data-breaches/{dataBreach}/notify', [DataBreachController::class, 'notify'])->name('data-breaches.notify');

    Route::get('note-types', [NoteTypeController::class, 'index'])->name('note-types.index');
    Route::post('note-types', [NoteTypeController::class, 'store'])->name('note-types.store');
    Route::put('note-types/{noteType}', [NoteTypeController::class, 'update'])->name('note-types.update');
    Route::delete('note-types/{noteType}', [NoteTypeController::class, 'destroy'])->name('note-types.destroy');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{uuid}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{uuid}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/settings.php';
