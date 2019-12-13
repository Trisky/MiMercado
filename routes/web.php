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
Route::get('/clear/{username?}', 'ProductosController@clearCache');
Route::get('/melilogin', 'AuthController@login');
Route::get('/wantlogin', 'AuthController@wantLogIn');
Route::get('/loginredirect{code}', 'AuthController@redirectCallback');

Auth::routes();


//React app

Route::view('/app/catalog/{path?}', 'app');
Route::view('app/{path?}', 'app');
Route::view('/', 'app');
Route::view('/{path?}', 'app');
