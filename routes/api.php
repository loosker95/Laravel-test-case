<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)
->prefix('v1')
->name('product.')
->group(function(){
    // Route::get('/products', 'index')->name('index')->middleware('throttle:3,60');
    Route::get('/products', 'index')->name('index');
    Route::post('/products', 'store')->name('create');
    Route::get('/products/{id}', 'show')->name('show');
    Route::put('/products/{id}', 'update')->name('update');
    Route::delete('/products/{id}', 'destroy')->name('delete');
});


