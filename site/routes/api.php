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
Route::get('course/{id}', 'CourseController@show');
Route::get('course', 'CourseController@index');
Route::patch('course/{id}', 'CourseController@create');
Route::put('course/{id}', 'CourseController@create');
Route::delete('course/{id}', 'CourseController@destroy');


Route::post('exam', 'ExamController@create');
Route::get('exam/{id}', 'ExamController@show');
Route::get('exam', 'ExamController@index');
Route::patch('exam/{id}', 'ExamController@create');
Route::put('exam/{id}', 'ExamController@create');
Route::delete('exam/{id}', 'ExamController@destroy');

Route::post('question', 'QuestionController@create');
Route::get('question/{id}', 'QuestionController@show');
Route::get('question', 'QuestionController@index');
Route::patch('question/{id}', 'QuestionController@create');
Route::put('question/{id}', 'QuestionController@create');
Route::delete('question/{id}', 'QuestionController@destroy');



//Route::post('logout', 'CourseController@logout');
//Route::post('refresh', 'CourseController@refresh');
//Route::post('login', 'CourseController@login');
//Route::post('logout', 'ExamController@logout');
//Route::post('refresh', 'ExamController@refresh');
