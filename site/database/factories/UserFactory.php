<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'surname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'Botte', // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(\App\QuestionAnswer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'isAnswer' => 'no',
        'question_id'=> '5', // password
    ];
    });
$factory->define(\App\Question::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'date_taken' => '2019/06/05',
        'marks' => '45',
        'exam_id' => function(){
            return factory('App\Exam')->create()->id;
        }, // password
    ];
});$factory->define(\App\Exam::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'exam_date' => '2019/06/05',
        'course_id' => function(){
            return factory('App\Course')->create()->id;
        }, // password
    ];
});
$factory->define(\App\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function(){
            return factory('App\User')->create()->id;
        }, // password
    ];
});
