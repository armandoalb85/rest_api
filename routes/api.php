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

//productos
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products','ProductsController',['only'=>['index','store','show',
    'destroy']]);
Route::put('products','ProductsController@update');

//proveedores
Route::resource('providers','ProvidersController',['only'=>['index','store','show',
    'destroy']]);
Route::put('providers','ProvidersController@update');

//tiendas
Route::resource('shops','ShopsController',['only'=>['index','store','show',
    'destroy']]);
Route::put('shops','ShopsController@update');

//ventas
Route::resource('sells','SellsController',['only'=>['index','store','show',
    'destroy']]);
Route::put('sells','SellsController@update');

//actualización de cantidades de productos
Route::put('stocks','StocksController@update');

//Route::resource('stocks','StocksController',['only'=>['update']]);