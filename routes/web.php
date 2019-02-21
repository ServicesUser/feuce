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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::prefix('e-voto')->group(function () {
        Route::get('/','MenuController@votosMenu')->name('voto.index');

        Route::get('/admin','AdministradorController@formulario')->name('voto.admin');
        Route::post('/admin','AdministradorController@nuevaAso');
        Route::options('/admin','AdministradorController@listaAso');


        Route::get('/aso','AsociacionController@vista')->name('voto.aso');
        Route::options('/aso','AsociacionController@listar');
    });
});

Route::prefix('app')->group(function () {
    Route::get('/','MenuController@generado');
});