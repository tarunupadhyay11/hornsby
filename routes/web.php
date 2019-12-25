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
    return redirect()->route('home');
});
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/users/{type}/get-all', 'UserController@getAll')->name('users.get-all');
Route::resource('users', 'UserController');
Route::post('get-all-users', 'UserController@getUsers')->name('get-all-users');
Route::post('/show-password','Usercontroller@ShowPassword')->name('show-password');
Route::post('/reset-password','Usercontroller@ResetPassword')->name('reset-password');
Route::post('/change-user-status','Usercontroller@changeStatus')->name('change-user-status');
Route::post('/get-usertypes','Usercontroller@getUsertypes')->name('get-usertypes');
Route::post('/get-countries','Usercontroller@getCountries')->name('get-countries');
Route::post('/get-states','Usercontroller@getStates')->name('get-states');
Route::post('/get-cities','Usercontroller@getCities')->name('get-cities');
Route::post('/get-transcriber','Usercontroller@getTranscriber')->name('get-transcriber');