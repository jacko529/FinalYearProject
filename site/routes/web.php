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

//Route::get('/', function () {
//    return view('welcome');
////});
//Route::get('/test', 'TestController@index');
//Route::get('/test', 'TestController@index');
Route::get('/', function () {
    return view('Auth.registration');
});
Route::get('/create', 'registration' );
Route::get('/login', function () {
    return view('Auth.login');
});
