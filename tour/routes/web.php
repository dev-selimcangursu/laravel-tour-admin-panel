<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tours',[TourController::class,'index'])->name('tours.index');
Route::get('/tours/create',[TourController::class,'create'])->name('tours.create');
Route::post('/tours/store',[TourController::class,'store'])->name('tours.store');
Route::get('/tours/fetch',[TourController::class,'fetch'])->name('tours.fetch');
Route::get('/tours/edit/{id}',[TourController::class,'edit'])->name('tours.edit');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
