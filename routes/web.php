<?php

use App\Http\Controllers\AdminBirthdayController;
use App\Http\Controllers\BirthdayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BirthdayController::class, 'index'])->name('birthday.index');
Route::get('/preview-nayla', [BirthdayController::class, 'preview'])->name('birthday.preview');

Route::get('/secret-admin-nayla', [AdminBirthdayController::class, 'edit'])->name('birthday.admin.edit');
Route::post('/secret-admin-nayla', [AdminBirthdayController::class, 'update'])->name('birthday.admin.update');

Route::post('/secret-admin-nayla/messages', [AdminBirthdayController::class, 'storeMessage'])->name('birthday.admin.messages.store');
Route::put('/secret-admin-nayla/messages/{message}', [AdminBirthdayController::class, 'updateMessage'])->name('birthday.admin.messages.update');
Route::delete('/secret-admin-nayla/messages/{message}', [AdminBirthdayController::class, 'destroyMessage'])->name('birthday.admin.messages.destroy');

Route::post('/secret-admin-nayla/memories', [AdminBirthdayController::class, 'storeMemory'])->name('birthday.admin.memories.store');
Route::put('/secret-admin-nayla/memories/{memory}', [AdminBirthdayController::class, 'updateMemory'])->name('birthday.admin.memories.update');
Route::delete('/secret-admin-nayla/memories/{memory}', [AdminBirthdayController::class, 'destroyMemory'])->name('birthday.admin.memories.destroy');

Route::post('/secret-admin-nayla/reasons', [AdminBirthdayController::class, 'storeReason'])->name('birthday.admin.reasons.store');
Route::put('/secret-admin-nayla/reasons/{reason}', [AdminBirthdayController::class, 'updateReason'])->name('birthday.admin.reasons.update');
Route::delete('/secret-admin-nayla/reasons/{reason}', [AdminBirthdayController::class, 'destroyReason'])->name('birthday.admin.reasons.destroy');

Route::post('/secret-admin-nayla/wishes', [AdminBirthdayController::class, 'storeWish'])->name('birthday.admin.wishes.store');
Route::put('/secret-admin-nayla/wishes/{wish}', [AdminBirthdayController::class, 'updateWish'])->name('birthday.admin.wishes.update');
Route::delete('/secret-admin-nayla/wishes/{wish}', [AdminBirthdayController::class, 'destroyWish'])->name('birthday.admin.wishes.destroy');
