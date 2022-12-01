<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//pages with pages controller

Route::get('/','PageController@index')->name('index');
///


Route::get('/course','CourseController@index')->name('coursehome');

Route::post('/coursecreate','CourseController@createcourse')->name('createcourse');

//Course sections
Route::get('/course/{id}','CourseController@sections')->name('coursesection');


Route::post('/course/section','CourseController@coursesection')->name('sectioncreate');


Route::get('/lessons/{id}','CourseController@sectionlessons')->name('sectionlessons');


///Create Lesson 

Route::post('/lesson/create','CourseController@createlessons')->name('createlessons');

