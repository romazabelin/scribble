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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::resource([
//    'clients' => 'ClientController'
//]);

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home.index']);

Route::post('/import-data-from-xls', ['uses' => 'TransferController@importDataFromXls', 'as' => 'transfer.import_data_from_xls']);

