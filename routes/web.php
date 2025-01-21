<?php

use App\Livewire\Devices\Edit;
use App\Livewire\Leaflet\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('livewire.test.show');
})->name('test');

Route::get('/network-show', Show::class)->name('network-show');


Route::get('/devices.show', App\Livewire\Devices\Show::class)->name('devices.show');
Route::get('/devices/{id}/edit', Edit::class)->name('devices.edit');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
