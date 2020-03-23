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

Route::post('/v1/register', 'Auth\Api\ApiRegisterController@register')->name('api.register');
Route::post('/v1/login', 'Auth\Api\ApiLoginController@login')->name('api.login');
Route::post('/v1/logout', 'Auth\Api\ApiLoginController@logout')->name('api.logout');

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Route::redirect('/v1', '/api/v1/document/page=1&perPage=20');
Route::get('/v1/document/page={page?}&perPage={perPage?}', 'Api\ApiDocumentController@index')
    ->name('api.documents.index')
    ->where(['page' => '[0-9]+', 'perPage' => '[0-9]+']);
Route::get('/v1/document/{id}', 'Api\ApiDocumentController@show')->name('api.documents.show');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/v1/document/', 'Api\ApiDocumentController@store')->name('api.documents.store');
    Route::patch('/v1/document/{id}', 'Api\ApiDocumentController@update')->name('api.documents.update');
    Route::post('/v1/document/{id}/publish', 'Api\ApiDocumentController@publish')->name('api.documents.publish');
});
