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


Route::resource('clients', 'ClientController')->names([
    'index' => 'client.list'
]);

Route::resource('products', 'ProductController')->names([
    'index'   => 'product.list',
    'edit'    => 'product.edit',
    'update'  => 'product.update',
    'destroy' => 'product.destroy'
]);

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home.index']);

Route::post('/import-data-from-xls', ['uses' => 'TransferController@importDataFromXls', 'as' => 'transfer.import_data_from_xls']);

