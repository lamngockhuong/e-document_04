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

Route::resource('/', 'Outside\IndexController', ['only' => ['index']]);

Route::resource('admin', 'Admin\IndexController', ['only' => ['index']]);

Route::resource('admin/categories', 'Admin\CategoryController', ['except' => ['show']]);

Route::get('admin/categories/ajax/subcategory/{id}', 'Admin\CategoryController@getSubCategory')->name('categories.ajax.subcategory');

Route::resource('admin/tags', 'Admin\TagController', ['except' => ['show']]);
