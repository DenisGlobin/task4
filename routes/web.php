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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::redirect('/', '/api/v1/document/?page=1&perPage=20');
Route::get('/api/v1/document/page={page?}&perPage={perPage?}', 'DocumentController@index')
    ->name('get.documents')
    ->where(['page' => '[0-9]+', 'perPage' => '[0-9]+']);
Route::get('/api/v1/document/{id}', 'DocumentController@getDocument')
    ->name('get.document')
    ->where(['id' => '[0-9A-Za-z]+']);

Route::middleware(['auth'])->group(function () {
    Route::post('/api/v1/document/', 'DocumentController@createDocument')->name('create.document');
    Route::patch('/api/v1/document/{id}', 'DocumentController@editDocument')
        ->name('edit.document')
        ->where(['id' => '[0-9A-Za-z]+']);
    Route::post('/api/v1/document/{id}/publish', 'DocumentController@publishDocument')
        ->name('publish.document')
        ->where(['id' => '[0-9A-Za-z]+']);
});
