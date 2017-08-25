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

Route::get('/dashboard', function() {
    return view('profile.dashboard');
});

Route::get('/teacherDashboard', function() {
    return view('teacherProfile.dashboard');
});

Route::get('/register/teacher', function () {
    return view('auth.registerTeacher');
});

Route::post('/register/teacher', 'Auth\RegisterController@registerTeacher');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
      Route::resource('profile', 'ProfileController');
      Route::resource('teacherProfile', 'TeacherProfileController');
      Route::resource('teacherEducation', 'TeacherEducationController');
      Route::resource('schedule', 'ScheduleController');
      Route::get('/schedule/ajax/{date}', 'ScheduleController@ajax');
      Route::get('/schedule/index_ajax/{date}', 'ScheduleController@index_ajax');
      Route::get('/reserveTeacher', 'ReserveTeacherController@index');
      Route::get('/reserveTeacher/{teacher_id}', 'ReserveTeacherController@show');
      Route::get('/reserveTeacher/ajax/{date}', 'ReserveTeacherController@ajax');
      Route::put('/reserveTeacher/{teacher_id}', 'ReserveTeacherController@update');
      Route::get('/lessons', 'ScheduleController@index');
      Route::get('/books', 'BookController@index');
      Route::post('/books', 'BookController@store');
      Route::delete('/books/{book_id}', 'BookController@destroy');
      Route::get('/messages', 'MessageController@index');
});
