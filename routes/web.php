<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// TODO: Remover o -- selecione -- após escolher uma data
// TODO: Listar os usuários cadastrados - OK
// TODO: Criar tela dos Meus horários
// TODO: Gravar agendamento fixo
// TODO: Permitir agendar, como admin, para todos os usuários
// TODO: Gerar relatório de agendamentos mensais informando para o usuário quanto ele deve pagar por mês
// TODO: Enviar e-mail após agendamento

Route::get('/', function () {
    return view('index.index');
})->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::group(['prefix' => 'app'],function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/clients', 'UserController@index')->name('user.index');
        Route::get('/new', 'UserController@create')->name('user.guest-create');
        Route::post('/store', 'UserController@store')->name('user.store');
        Route::get('/edit/{user_id}', 'UserController@edit')->name('user.edit');
        Route::put('/update', 'UserController@update')->name('user.update');

    });

    Route::group(['prefix' => 'schedule', 'middleware' => 'auth'], function () {
        Route::get('/', 'ScheduleController@index')->name('schedule.index');
        Route::get('/modal-schedule', 'ScheduleController@modalSchedule')->name('schedule.modal-schedule');
        Route::post('/to-schedule', 'ScheduleController@store')->name('schedule.store');
        Route::post('/', 'ScheduleController@showSpecificShcedule')->name('schedule.show-specific-shedule');
        Route::post('/to-destroy-schedule', 'ScheduleController@destroy')->name('schedule.destroy');
        Route::get('/my-schedules', 'ScheduleController@mySchedules')->name('schedule.my-schedules');
    });
});

