<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get(uri: 'getProdutos', action: 'App\Http\Controllers\ProdutoController@getProdutos');

Route::get(uri: 'getProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@getProdutosById');

Route::post(uri: 'postProdutos', action: 'App\Http\Controllers\ProdutoController@postProdutos');

Route::post(uri: 'putProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@putProdutos');

Route::delete(uri: 'deleteProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@deleteProdutos');
