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

Route::group(['namespace' => 'Outside'], function () {
    Route::resource('/', 'IndexController', ['only' => ['index']]);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::resource('', 'IndexController', ['only' => ['index']]);
    Route::resource('categories', 'CategoryController', ['except' => ['show']]);
    Route::resource('tags', 'TagController', ['except' => ['show']]);
    Route::resource('users', 'UserController', ['except' => ['show']]);
    Route::resource('documents', 'DocumentController', ['except' => ['show']]);
});

Auth::routes();
