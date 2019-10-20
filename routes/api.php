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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * List of routes for legal entity resource
 */
Route::prefix('legal-entity')->group(function () {

	Route::post('create', 'LegalEntityController@create');
    
    Route::put('update/{id}','LegalEntityController@update');

    Route::get('all','LegalEntityController@filter');

    Route::get('lei/{lei}','LegalEntityController@filterByLEI');

    Route::get('history/{id}','LegalEntityController@filterHistory');
});
