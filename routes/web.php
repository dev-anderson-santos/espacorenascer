<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// TODO: Remover o -- selecione -- após escolher uma data
// TODO: Enviar e-mail após agendamento - NÃO PEDIU
// TODO: Resetar senha por email - NÃO PEDIU
// TODO: Calcular os dias para espelhar os agendamentos (verificar se o dia de hoje + 6 dias é o próximo mês)

Route::get('/', function () {
    return view('index.index');
})->name('index');

Auth::routes();
Route::post('/login', [
    'uses'          => 'Auth\LoginController@login',
    'middleware'    => 'checkstatus',
]);

Route::group(['prefix' => 'app'],function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/clients', 'UserController@index')->middleware('auth')->name('user.index');
        Route::get('/new', 'UserController@create')->name('user.guest-create');
        Route::post('/store', 'UserController@store')->name('user.store');
        Route::get('/edit/{user_id}', 'UserController@edit')->middleware('auth')->name('user.edit');
        Route::put('/update', 'UserController@update')->middleware('auth')->name('user.update');
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
        Route::post('/destroy-schedule-next-month', 'ScheduleController@destroyNextMonth');
        Route::post('/mudar-tipo-agendamento-proximo-mes', 'ScheduleController@mudarTipoAgendamentoProximoMes');
        Route::post('/cancel-all-fixed-schedules/{user_id?}', 'ScheduleController@cancelAllFixedSchedules');
        Route::post('/cancel-all-fixed-next-month-schedules/{user_id?}', 'ScheduleController@cancelAllFixedNextMonthSchedules');
        Route::get('/modal-cancelar-agendamento-fixo', 'ScheduleController@modalCancelarAgendamentoFixo')->name('schedule.modal-cancelar-agendamento-fixo');
        Route::post('/cancelar-agendamento-fixo', 'ScheduleController@cancelarAgendamentoFixo')->name('schedule.cancelar-agendamento-fixo');
        Route::get('/index-administrador', 'ScheduleController@indexAdmin')->name('schedule.index-administrador');
        Route::post('/index-administrador', 'ScheduleController@showSpecificShceduleAdministrador')->name('schedule.show-specific-shedule-administrador');
    });

    Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::post('/', 'SettingsController@update')->name('settings.update');
        Route::get('/update-settings-ajax', 'SettingsController@updateSettingsAjax')->name('settings.update-settings-ajax');
        Route::get('/modal-adicionar-data-nao-faturada', 'SettingsController@modalAdicionarDataNaoFaturada')->name('settings.adicionarDataNaoFaturada');
        Route::post('/adicionar-data-nao-faturada', 'SettingsController@adicionarDataNaoFaturada')->name('settings.adicionarDataNaoFaturada');
        Route::get('/remover-data-nao-faturada', 'SettingsController@removerDataNaoFaturada')->name('settings.removerDataNaoFaturada');
    });
});

