<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

use App\Http\Controllers\DishController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::controller(DishController::class)->group(function () {
    Route::get('/dish', 'edit')->name('dishes.edit');
    Route::post('/dish', 'store')->name('dishes.store');
    Route::put('/dish/{dish}', 'update')->name('dishes.update');
    Route::delete('/dish/{dish}', 'destroy')->name('dishes.destroy');
});

Route::controller(\App\Http\Controllers\LikeController::class)->group(function () {
    Route::post('/like', 'storeOrDelete')->name('likes.storeOrDelete');
});
