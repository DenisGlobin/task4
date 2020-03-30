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


//Auth::routes();

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Route::redirect('/', '/documents/page=1&perPage=10');
Route::get('/documents/page={page?}&perPage={perPage?}', function () {
    return view('vue.index');
});
//Route::get('/documents/page={page?}&perPage={perPage?}', 'DocumentController@index')
//    ->name('documents.index')
//    ->where(['page' => '[0-9]+', 'perPage' => '[0-9]+']);
//Route::post('documents/{id}/publish', 'DocumentController@publish')
//    ->name('documents.publish')
//    ->middleware('auth');
//Route::resource('documents', 'DocumentController')->parameters([
//    'documents' => 'id'
//    ])->except(['index', 'destroy']);