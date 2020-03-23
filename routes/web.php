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


Auth::routes();

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Route::redirect('/', '/documents');
Route::post('document/{id}/publish', 'DocumentController@publish')
    ->name('publish')
    ->middleware('auth');
Route::resource('documents', 'DocumentController')->parameters([
    'documents' => 'id'
    ])->except('destroy');