<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdministratorController;

// TODO: Remover o -- selecione -- após escolher uma data
// TODO: Enviar e-mail após agendamento - NÃO PEDIU
// TODO: Resetar senha por email - NÃO PEDIU
// TODO: Calcular os dias para espelhar os agendamentos (verificar se o dia de hoje + 6 dias é o próximo mês)

// TODO: remover os agendamentos em sequencia e até os espelhados
// TODO: espelhar automatico
// TODO: remover os agendamentos espelhados

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

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'schedule'], function() {
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
            Route::get('/agenda-mes', 'ScheduleController@agendaMes')->name('schedule.agenda-mes');
            Route::post('/agenda-mes', 'ScheduleController@showSpecificShceduleMes')->name('schedule.show-specific-shedule-mes');
        });
    
        Route::group(['middleware' => 'is_admin'], function () {
            Route::group(['prefix' => 'settings'], function() {
                Route::get('/', 'SettingsController@index')->name('settings.index');
                Route::post('/', 'SettingsController@update')->name('settings.update');
                Route::get('/update-settings-ajax', 'SettingsController@updateSettingsAjax')->name('settings.update-settings-ajax');
                Route::get('/modal-adicionar-data-nao-faturada', 'SettingsController@modalAdicionarDataNaoFaturada')->name('settings.adicionarDataNaoFaturada');
                Route::post('/adicionar-data-nao-faturada', 'SettingsController@adicionarDataNaoFaturada')->name('settings.adicionarDataNaoFaturada');
                Route::get('/remover-data-nao-faturada', 'SettingsController@removerDataNaoFaturada')->name('settings.removerDataNaoFaturada');
                Route::get('/faturar-agendamentos', 'SettingsController@faturar')->name('settings.faturar');
                Route::get('/espelhar-agendamentos', 'SettingsController@mirror')->name('settings.mirror');
                Route::get('/excluir-agendamentos-espelhados', 'SettingsController@deleteMirroredSchedules')->name('settings.removerDataNaoFaturada');
                Route::get('/generate-invoicing', 'SettingsController@generateInvoicing')->name('settings.generate-invoicing');
            });

            Route::group(['prefix' => 'rooms'], function() {
                Route::get('/', 'RoomController@index')->name('room.index');
                Route::get('/modal-adicionar-sala', 'RoomController@create')->name('room.create');
                Route::get('/modal-editar-sala/{id}', 'RoomController@edit')->name('room.edit');
                Route::post('/atualizar-sala', 'RoomController@update')->name('room.update');
                Route::post('/adicionar-sala', 'RoomController@store')->name('room.store');
                Route::get('/verificar-sala-em-uso', 'RoomController@verificarSalaEmUso')->name('room.check-room-in-use');
                Route::get('/remover-sala', 'RoomController@destroy')->name('room.destroy');
            });
        });

        Route::group(['prefix' => 'reports', 'middleware' => 'is_admin'], function () {
            Route::get('/', 'ReportsController@index')->name('reports.index');
            Route::post('/', 'ReportsController@showSpecificInvoicing')->name('reports.show-specific-invoicing');
        });

        Route::group(['prefix' => 'admin', 'middleware' => 'is_admin', 'as' => 'admin'], function () {
            Route::get('/dashboard', [AdministratorController::class, 'dashboard'])->name('.dashboard');
        });
    });
});

