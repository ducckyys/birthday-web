<?php

use App\Http\Controllers\BirthdayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BirthdayController::class, 'index'])->name('birthday.index');
