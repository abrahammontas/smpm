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

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {

    Route::get('cron', 'CronController@index');

    Route::resource('account', 'AccountController');

    Route::resource('post', 'PostController');

    Route::resource('ImagesPost', 'ImagesPostController');
});

Route::group(['middleware' => ['guest']], function () {

    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
});

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
