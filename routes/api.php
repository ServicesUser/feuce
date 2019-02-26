<?php

use Illuminate\Http\Request;
use Hashids\Hashids;

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
Route::get('a/{a}',function($a){
    $aux = new Hashids('',5,'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    return (['encode'=>$aux->encode($a),'decode'=>$aux->decode($aux->encode($a))]);
});

Route::get('movimientos/{token}','OpcionesController@buscarLogo')->name('get.logo');
Route::get('candidatos/{token}','OpcionesController@buscarCandidato')->name('get.foto');

Route::get('mov','OpcionesController@movimientos');
Route::post('mov','OpcionesController@nuevoMov');

Route::get('dig','OpcionesController@dignidades');
Route::post('dig','OpcionesController@nuevaDig');
