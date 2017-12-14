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


# Guest Routes for Get operations
Route::get('/Hello', 'OptionsController@hello');

Route::get('/', 'OptionsController@home');
Route::get('/Home', 'OptionsController@home');
Route::get('/CreateContract', 'OptionsController@createContract');
Route::get('/About', 'OptionsController@about');
Route::get('/Help', 'OptionsController@help');
Route::get('/ContractList/{status}/{symbol}', 'OptionsController@contractList');
Route::get('/ContractDetail/{contract_id}', 'OptionsController@contractDetail');

Route::post('/Search', 'OptionsController@search');
Route::post('/AdvancedSearch', 'OptionsController@advancedSearch');
Route::post('/postCreateContract', 'OptionsController@postCreateContract');
Route::post('/postPurchaseContract', 'OptionsController@purchaseContract');
Route::post('/postDeleteContract', 'OptionsController@deleteContract');
Route::post('/postUpdateContract', 'OptionsController@updateContract');




/*
Route::get('/', function () {
    return view('hello');
});
*/
