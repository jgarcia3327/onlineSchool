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
});

Route::get('/profile/{profile}', 'ProfileController@show');
