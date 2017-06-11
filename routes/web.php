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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {

    Route::resource('account', 'AccountController');

    Route::resource('post', 'PostController');

    Route::resource('ImagesPost', 'ImagesPostController');

	Route::get('change-password', 'Auth\UserController@change');
	
	Route::post('change-password', 'Auth\UserController@update');

	Route::get('edit-profile', 'Auth\UserController@index');
	
	Route::post('edit-profile', 'Auth\UserController@edit');
});


Route::get('cron', 'CronController@index');

Route::group(['middleware' => ['guest']], function () {

    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
});

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
