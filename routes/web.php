<?php

use App\Http\Controllers\DeputyController;
use Illuminate\Support\Facades\Route;



Route::get('/', [DeputyController::class, 'index'])->name('deputies');
Route::get('/deputy/{id}', [DeputyController::class, 'show'])->name('deputy');