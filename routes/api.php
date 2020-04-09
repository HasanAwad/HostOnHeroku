<?php

use Illuminate\Http\Request;
use App\Currencies;

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



Route::post('login', 'APIController@login');
Route::post('register', 'APIController@register');
//get all Currencies no need for user auth anyone can access this route
Route::get('currencie_all', 'CurrenciesController@index');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'APIController@logout');
    //get transactions for specific user
    Route::get('transactions', 'TransactionsController@index');
    //add new transactions
    Route::post('transactions', 'TransactionsController@store');
    //delete transactions
    Route::delete('transactions/{id}', 'TransactionsController@destroy');
    //edit transaction by id
    Route::put('transactions/{id}', 'TransactionsController@update');
    //get all categories for specific user
    Route::get('categories','CategoriesController@index');
    // add new category
    Route::post('categories','CategoriesController@store');
    //delete specific category by id
    Route::delete('categories/{id}', 'CategoriesController@destroy');
    //edit specific category by id
    Route::put('categories/{id}', 'CategoriesController@update');

});
