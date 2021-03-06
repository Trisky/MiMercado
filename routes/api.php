<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products/{username}', 'ProductosController@apiProducts');
Route::get('/admin/products/{username}', 'Admin\AdminProductsController@apiProducts');
Route::post('/admin/visibility/show/{product_id}', 'Admin\VisibilityController@show');
Route::post('/admin/visibility/hide/{product_id}', 'Admin\VisibilityController@hide');

