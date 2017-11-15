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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/filter', 'HomeController@filter');
    Route::post('/home/apply', 'HomeController@apply');
    Route::get('/home/table', 'HomeController@table');
    Route::get('/home/doughnut', 'HomeController@doughnut');
    Route::get('/home/line', 'HomeController@line');
    Route::get('/home/bar', 'HomeController@bar');    
    Route::get('/home/seed', 'HomeController@seed');

Route::resource('users', 'UserController');