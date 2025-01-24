<?php

use App\Livewire\Devices\Edit;
use App\Livewire\Points\Show;
use Illuminate\Support\Facades\Route;

Route::get("/link", function () {
    $exitCode = Artisan::call('storage:link');
    return "Symlink created with exit code: $exitCode";
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/network-show/{id}', Show::class)->name('network-show');
    Route::get('/devices.show', App\Livewire\Devices\Show::class)->name('devices.show');
    Route::get('/devices/{id}/edit', Edit::class)->name('devices.edit');
    Route::get('/networks', App\Livewire\Networks\Show::class)->name('networks.show');
});
