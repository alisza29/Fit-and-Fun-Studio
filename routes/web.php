<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', 'HomeController@index')->name('home');

// ini rolenya tuh cuma buat admin aja atau user aja, terus lanjutin dibawahnya controller crudnya
Route::group(['middleware' => ['role:admin']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/register', 'AuthController@register')->name('register');
});

Route::group(['middleware' => ['role:user']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/register', 'AuthController@register')->name('register');
});