<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vue', function () {
    return view('vue');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    
    Route::name('people.')->group(function () {
        Route::get('/people', [App\Http\Controllers\PersonController::class, 'index'])->name('index');
        Route::post('/people', [App\Http\Controllers\PersonController::class, 'store'])->name('store');
    });

    Route::get('/trigger/{data}', function ($data) {
        echo "<p>You have sent $data</p>";
        event(new App\Events\GetRequestEvent($data));
    });
});
