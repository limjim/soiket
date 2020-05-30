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
Route::group(['namespace' => 'Frontend'], function() {
    Route::get('/callback', ['uses' => 'HomeController@callback']);
    Route::get('/zalo', ['uses' => 'HomeController@connectZalo']);
});

Auth::routes();
Route::group(['middleware' => ['auth'], 'namespace' => 'System'], function () {
    Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/password', ['as' => 'password', 'uses' => 'ProfileController@password']);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);
    Route::get('/friends', ['as' => 'friend', 'uses' => 'FriendController@index']);
});

Route::group(['prefix' => 'service', 'namespace' => 'Service', 'middleware' => ['auth']], function() {
    Route::get('friend/find', ['as' => 'friend:find', 'uses' => 'FriendService@find']);
    Route::get('/fetch-friends', ['uses' => 'FriendService@fetchFriends']);
});
