<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/clients', [ClientController::class, 'index'])->middleware(['auth', 'verified'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->middleware(['auth', 'verified'])->name('clients.create');
Route::get('/clients/{id}', [ClientController::class, 'detail'])->middleware(['auth', 'verified'])->name('clients.detail');
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->middleware(['auth', 'verified'])->name('clients.edit');
Route::post('/clients/store', [ClientController::class, 'store'])->middleware(['auth', 'verified'])->name('clients.store');
Route::put('/clients/{id}/update', [ClientController::class, 'update'])->middleware(['auth', 'verified'])->name('clients.update');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
