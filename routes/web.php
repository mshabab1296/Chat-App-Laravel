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

Route::get('message/index', 'MessageController@index');
Route::get('message/send', 'MessageController@send');

Route::get('user/chat', 'ChatController@index')->name('user.chat');
Route::post('user/chat/message/send', 'ChatController@sendMessage');