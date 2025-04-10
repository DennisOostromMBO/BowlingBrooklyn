<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;

Route::prefix('scores')->group(function () {
    Route::get('/', [ScoreController::class, 'index'])->name('scores.index');
    Route::get('/create', [ScoreController::class, 'create'])->name('scores.create');
    Route::post('/', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/{id}/edit', [ScoreController::class, 'edit'])->name('scores.edit');
    Route::put('/{id}', [ScoreController::class, 'update'])->name('scores.update');
    Route::delete('/{id}', [ScoreController::class, 'destroy'])->name('scores.destroy');
});