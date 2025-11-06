<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Clients\ClientControllerIndex;
use App\Http\Controllers\Clients\CreateClientController;
use App\Http\Controllers\Clients\EditClientController;
use App\Http\Controllers\Clients\StoreClientController;
use App\Http\Controllers\Clients\UpdateClientController;
use App\Http\Controllers\Clients\RemoveClientController;
use App\Http\Controllers\Invoices\IndexInvoiceController;
use App\Http\Controllers\Invoices\CreateInvoiceController;
use App\Http\Controllers\Invoices\StoreInvoiceController;
use App\Http\Controllers\Invoices\EditInvoiceController;
use App\Http\Controllers\Invoices\UpdateInvoiceController;
use App\Http\Controllers\Invoices\RemoveInvoiceController;
use App\Http\Controllers\Invoices\EditInvoiceItemsController;
use App\Http\Controllers\Invoices\UpdateInvoiceItemsController;
use App\Http\Controllers\Invoices\ExportInvoicePdfController;
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
    Route::get('/clients/{client}/edit', EditClientController::class)->name('clients.edit')->middleware('role:' . Role::SUPER_ADMIN);
    Route::put('/clients/{client}', UpdateClientController::class)->name('clients.update')->middleware('role:' . Role::SUPER_ADMIN);
    Route::delete('/clients/{client}', RemoveClientController::class)->name('clients.remove')->middleware('role:' . Role::SUPER_ADMIN);

    // Invoices
    Route::get('/invoices', IndexInvoiceController::class)->name('invoices.index')->middleware('role:' . Role::SUPER_ADMIN);
    Route::get('/invoices/create', CreateInvoiceController::class)->name('invoices.create')->middleware('role:' . Role::SUPER_ADMIN);
    Route::post('/invoices', StoreInvoiceController::class)->name('invoices.store')->middleware('role:' . Role::SUPER_ADMIN);
    Route::get('/invoices/{invoice}/edit', EditInvoiceController::class)->name('invoices.edit')->middleware('role:' . Role::SUPER_ADMIN);
    Route::put('/invoices/{invoice}', UpdateInvoiceController::class)->name('invoices.update')->middleware('role:' . Role::SUPER_ADMIN);
    Route::delete('/invoices/{invoice}', RemoveInvoiceController::class)->name('invoices.remove')->middleware('role:' . Role::SUPER_ADMIN);
    
    // Invoice Items
    Route::get('/invoices/{invoice}/items/edit', EditInvoiceItemsController::class)->name('invoices.items.edit')->middleware('role:' . Role::SUPER_ADMIN);
    Route::put('/invoices/{invoice}/items', UpdateInvoiceItemsController::class)->name('invoices.items.update')->middleware('role:' . Role::SUPER_ADMIN);
    
    // Invoice PDF Export
    Route::get('/invoices/{invoice}/export-pdf', ExportInvoicePdfController::class)->name('invoices.export.pdf')->middleware('role:' . Role::SUPER_ADMIN);
});

require __DIR__.'/auth.php';
