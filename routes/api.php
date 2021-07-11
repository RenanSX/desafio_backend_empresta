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

// Rota de convenios
Route::group([
    'prefix' => 'convenios',
    'middleware' => 'autenticador'
], function () {
    Route::get('/', 'ConvenioController@index');
});
// Rota de Instituiçoes
Route::group([
    'prefix' => 'instituicoes',
    'middleware' => 'autenticador'
], function () {
    Route::get('/', 'InstituicaoController@index');
});
// Credito
Route::group([
    'prefix' => 'credito',
    'middleware' => 'autenticador'
], function () {
    Route::post('/disponivel', 'CreditoController@creditAvailable');
});
