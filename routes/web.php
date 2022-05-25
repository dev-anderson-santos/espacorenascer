<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// TODO: Remover o -- selecione -- após escolher uma data
// TODO: Permitir agendar, como admin, para todos os usuários
// TODO: Gerar relatório de agendamentos mensais informando para o usuário quanto ele deve pagar por mês
// TODO: Enviar e-mail após agendamento
// TODO: Resetar senha por email
// TODO: Colocar no campo faturado = 1 quando chegar no dia 31 e exibir os agendamentos em Meus horários enquanto não estiverem faturados

Route::get('/', function () {
    return view('index.index');
})->name('index');

Auth::routes();

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
        Route::get('/user-schedules/{user_id?}', 'ScheduleController@userSchedules')->name('schedule.user-schedules');
        Route::get('/fechamento-mes/{user_id?}', 'ScheduleController@fechamentosDoMes')->name('schedule.fechamento-mes');
        Route::post('/mudar-tipo-agendamento', 'ScheduleController@mudarTipoAgendamento')->name('schedule.mudar-tipo-agendamento');
        Route::get('/update-all-schedules', 'ScheduleController@updateAllSchedules')->name('schedule.update-all-schedules');
        Route::get('/details', 'ScheduleController@details')->name('schedule.details');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::post('/', 'SettingsController@update')->name('settings.update');
    });
});

