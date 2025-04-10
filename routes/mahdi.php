<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit'); // Add this line
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update'); // Update route