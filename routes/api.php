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

Route::middleware([App\Http\Middleware\EnsureTokenIsValid::class])->group(function(){
    //ROTA PARA GET DE TODOS OS PRODUTOS
    Route::get(uri: 'getProdutos', action: 'App\Http\Controllers\ProdutoController@getProdutos');

    //ROTA PARA GET DE UM PRODUTO PELO ID
    Route::get(uri: 'getProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@getProdutosById');
    
    //ROTA PARA CADASTRAR UM PRODUTO
    Route::post(uri: 'postProdutos', action: 'App\Http\Controllers\ProdutoController@postProdutos');
    
    //ROTA PARA ATUALIZAR UM PRODUTO PELO ID
    Route::put(uri: 'putProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@putProdutos');
    
    //ROTA PARA DELETER UM PRODUTO PELO ID
    Route::delete(uri: 'deleteProdutos/{id}', action: 'App\Http\Controllers\ProdutoController@deleteProdutos');
});

//ROTA
Route::post(uri:'postUser', action: 'App\Http\Controllers\UserController@postUser');

//ROTA
Route::post(uri:'getToken', action: 'App\Http\Controllers\UserController@getToken');


