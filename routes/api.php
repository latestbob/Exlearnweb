<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//get all courses

Route::get('/courses','CourseController@getallcourses');
Route::get('/course/{coursecode}','CourseController@getuniquecourse');

//Get all sections

Route::get('/sections/{coursecode}','CourseController@getallsections');
Route::get('/section/{section_code}','CourseController@getUniqueSection');

//Get Lessons in a section

Route::get('/lessons/{section_code}','CourseController@getLessons');

Route::get('/lesson/{id}','CourseController@getUniquelesson');


///////////////////////////////AUTH ROUTE HERE////////////////////

Route::post('/register','AuthController@register')->name('register');
Route::post('/login','AuthController@login')->name('login');



Route::get('/user','AuthController@user')->middleware('auth:sanctum');


//get free courses


Route::get('/free','CourseController@free');

///Order purchase Post routes

Route::post("/payment",'CourseController@payment');


//get purchased courseds

Route::get('/purchased/{email}','CourseController@purchased');

///get all course by a particular user

Route::get('/mycourse/{email}','CourseController@showcourses');

//Validate Email Address /forgot password

Route::post('/forgot-password','AuthController@forgotpassword');

Route::post('/reset-password','AuthController@resetpassword');

Route::get('/publickey','CourseController@getpublickey');


//feedback routes

Route::post('/feedback','CourseController@feedback');

Route::get('/feedbacks','CourseController@feedbacks');


