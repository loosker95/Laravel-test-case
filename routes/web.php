<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::controller(MainController::class)->group(function(){
        Route::middleware('isAdmin')->group(function(){
            Route::get('/create', 'create')->name('create.post');
            Route::post('/store', 'store')->name('store.post');
        });

        Route::get('/post/{id}/edit', 'edit')->name('edit.post');
        Route::put('/update/{id}', 'update')->name('update.post');
        Route::delete('/delete/{id}', 'destroy')->name('destroy.post');
        Route::get('/dashboard', 'index')->name('dashboard');

    });
});
