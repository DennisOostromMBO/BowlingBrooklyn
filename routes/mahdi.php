<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
