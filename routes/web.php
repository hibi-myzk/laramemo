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

Route::get('memos', 'MemoController@index')->name('memos.index');
Route::get('memos/new', 'MemoController@new')->name('memos.new');
Route::post('memos', 'MemoController@create')->name('memos.create');
Route::get('memos/{memo}/edit', 'MemoController@edit')->name('memos.edit');
Route::get('memos/{memo}', 'MemoController@show')->name('memos.show');
Route::patch('memos/{memo}', 'MemoController@update')->name('memos.update');