<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/create', 'UserController@create');

Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::post('course', 'CourseController@create');
//Route::post('logout', 'CourseController@logout');
//Route::post('refresh', 'CourseController@refresh');
//Route::post('login', 'CourseController@login');
//Route::post('logout', 'ExamController@logout');
//Route::post('refresh', 'ExamController@refresh');
