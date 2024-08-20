<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', [ProfileController::class, 'index']);

Route::get('/profiles/create', [ProfileController::class, 'create']);
Route::post('/profiles', [ProfileController::class, 'store'])->name('profile.create');

Route::get('/profiles/{profile}/edit', [ProfileController::class, 'edit']);
Route::put('/profiles/{profile}/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy']);
