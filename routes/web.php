<?php

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/user','UserController@index');
Route::get('/', 'ProductosController');
Route::get('/clear', 'ProductosController@clearCache');
Route::get('/login', 'AuthController@login');
Route::get('/wantlogin', 'AuthController@wantLogIn');
Route::get('/loginredirect{code}', 'AuthController@redirectCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
