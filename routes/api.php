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

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Route::redirect('/', '/api/v1/document/?page=1&perPage=20');
Route::get('/v1/document/page={page?}&perPage={perPage?}', 'DocumentController@index')
    ->name('get.documents')
    ->where(['page' => '[0-9]+', 'perPage' => '[0-9]+']);
Route::get('/v1/document/{id}', 'DocumentController@getDocument')
    ->name('get.document');
//    ->where(['id' => '^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/v1/document/', 'DocumentController@createDocument')->name('create.document');
    Route::patch('/api/v1/document/{id}', 'DocumentController@editDocument')
        ->name('edit.document');
//        ->where(['id' => '^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}']);
    Route::post('/v1/document/{id}/publish', 'DocumentController@publishDocument')
        ->name('publish.document');
//        ->where(['id' => '^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}']);
});
