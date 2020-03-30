<?php

//use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Route::redirect('/v1', '/api/v1/document/page=1&perPage=20');

Route::group(['prefix' => 'v1'], function () {
    // Guest's routes
    // Documents routes
    Route::get('document/page={page?}&perPage={perPage?}', 'API\DocumentController@index')
        ->name('api.documents.index')
        ->where(['page' => '[0-9]+', 'perPage' => '[0-9]+']);
    Route::get('document/{id}', 'API\DocumentController@show')->name('api.documents.show');
    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'API\AuthController@register')->name('register');
        Route::post('login', 'API\AuthController@login')->name('login');
        Route::get('refresh', 'API\AuthController@refresh');
        // Authenticated User's routes
        Route::group(['middleware' => 'auth:api'], function () {
            // Auth routes
            Route::get('user', 'API\AuthController@user')->name('user');
            Route::post('logout', 'AuthController@logout')->name('logout');
            // Documents routes
            Route::post('document/', 'API\DocumentController@store')->name('api.documents.store');
            Route::patch('document/{id}', 'API\DocumentController@update')->name('api.documents.update');
            Route::post('document/{id}/publish', 'API\DocumentController@publish')->name('api.documents.publish');
        });
    });
});

