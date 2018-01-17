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

Route::group(['namespace' => 'Outside', 'prefix' => ''], function () {
    Route::resource('', 'IndexController', ['only' => ['index'], 'names' => ['index' => 'public.index']]);
    Route::get('document/{slug}-{id}', 'DocumentController@detail')->name('document.detail')->where(['slug' => '.+', 'id' => '[0-9]+']);
});

Route::middleware(['auth'])->namespace('Outside')->prefix('')->group(function () {
    Route::get('document/download/{token}/{id}', 'DocumentController@showDownload')->name('document.download')->where(['token' => '.+', 'id' => '[0-9]+']);
    Route::post('document/ajax/check-download', 'DocumentController@checkDownload')->name('document.checkDownload');
    Route::get('document/force-download/{token}/{id}', 'DocumentController@forceDownload')->name('document.forceDownload')->where(['token' => '.+', 'id' => '[0-9]+']);
    Route::post('document-manager/ajax/upload', 'DocumentManagerController@upload')->name('document-manager.upload');
    Route::get('document-manager/ajax/subcategories/{id}', 'DocumentManagerController@getSubCategories')->name('document-manager.subcategories');
    Route::put('document-manager/ajax/{id}/save', 'DocumentManagerController@save')->name('document-manager.save');
    Route::resource('document-manager', 'DocumentManagerController');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::resource('', 'IndexController', ['only' => ['index']]);
    Route::resource('categories', 'CategoryController', ['except' => ['show']]);
    Route::resource('tags', 'TagController', ['except' => ['show']]);
    Route::resource('users', 'UserController', ['except' => ['show']]);
    Route::resource('documents', 'DocumentController', ['except' => ['show']]);
});

Auth::routes();
