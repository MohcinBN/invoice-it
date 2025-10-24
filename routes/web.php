<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Clients\ClientControllerIndex;
use App\Http\Controllers\Clients\CreateClientController;
use App\Http\Controllers\Clients\StoreClientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Constants\Role;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/clients', ClientControllerIndex::class)->name('clients.index')->middleware('role:' . Role::SUPER_ADMIN);
    Route::get('/clients/create', CreateClientController::class)->name('clients.create')->middleware('role:' . Role::SUPER_ADMIN);
    Route::post('/clients', StoreClientController::class)->name('clients.store')->middleware('role:' . Role::SUPER_ADMIN);
});

require __DIR__.'/auth.php';
