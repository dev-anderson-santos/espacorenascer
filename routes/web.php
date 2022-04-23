<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('index.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/create', 'HomeController@create')->name('guest.create');

Route::group(['prefix' => 'app'],function () {
    Route::group(['prefix' => 'schedule', 'middleware' => 'auth'], function () {
        Route::get('/', 'ScheduleController@index')->name('schedule.index');
        Route::get('/modal-schedule', 'ScheduleController@modalSchedule')->name('schedule.modal-schedule');
        Route::post('/to-schedule', 'ScheduleController@store')->name('schedule.store');
        Route::post('/', 'ScheduleController@showSpecificShcedule')->name('schedule.show-specific-shedule');
        Route::post('/to-destroy-schedule', 'ScheduleController@destroy')->name('schedule.destroy');
    });
});

