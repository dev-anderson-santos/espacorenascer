<?php

namespace App\Observers;

use App\Models\Historic;
use App\Models\SchedulesNextMonthModel;

class SchedulesNextMonthObserver
{
    /**
     * Handle the schedules next month model "created" event.
     *
     * @param  \App\Models\SchedulesNextMonthModel  $schedulesNextMonthModel
     * @return void
     */
    public function created(SchedulesNextMonthModel $schedulesNextMonthModel)
    {
        Historic::create([
            'action' => 'create',
            'user_id' => $schedulesNextMonthModel->user_id,
            'room_id' => $schedulesNextMonthModel->room_id,
            'created_by' => auth()->user()->id,
            'hour_id' => $schedulesNextMonthModel->hour_id,
            'date' => $schedulesNextMonthModel->date,
            'status' => $schedulesNextMonthModel->status,
            'tipo' => $schedulesNextMonthModel->tipo,
            'faturado' => $schedulesNextMonthModel->faturado,
            'finalizado_em' => $schedulesNextMonthModel->finalizado_em,
            'data_nao_faturada_id' => $schedulesNextMonthModel->data_mnao_faturada_id,
            'last_login_time' => now(),
            'last_login_ip' => request()->getClientIp(),
            'scheduleForNextMonth' => 1
        ]);
    }

    /**
     * Handle the schedules next month model "updated" event.
     *
     * @param  \App\Models\SchedulesNextMonthModel  $schedulesNextMonthModel
     * @return void
     */
    public function updated(SchedulesNextMonthModel $schedulesNextMonthModel)
    {
        Historic::create([
            'action' => 'update',
            'user_id' => $schedulesNextMonthModel->user_id,
            'room_id' => $schedulesNextMonthModel->room_id,
            'created_by' => auth()->user()->id,
            'hour_id' => $schedulesNextMonthModel->hour_id,
            'date' => $schedulesNextMonthModel->date,
            'status' => $schedulesNextMonthModel->status,
            'tipo' => $schedulesNextMonthModel->tipo,
            'faturado' => $schedulesNextMonthModel->faturado,
            'finalizado_em' => $schedulesNextMonthModel->finalizado_em,
            'data_nao_faturada_id' => $schedulesNextMonthModel->data_mnao_faturada_id,
            'last_login_time' => now(),
            'last_login_ip' => request()->getClientIp(),
            'scheduleForNextMonth' => 1
        ]);
    }

    /**
     * Handle the schedules next month model "deleted" event.
     *
     * @param  \App\Models\SchedulesNextMonthModel  $schedulesNextMonthModel
     * @return void
     */
    public function deleted(SchedulesNextMonthModel $schedulesNextMonthModel)
    {
        Historic::create([
            'action' => 'delete',
            'user_id' => $schedulesNextMonthModel->user_id,
            'room_id' => $schedulesNextMonthModel->room_id,
            'created_by' => auth()->user()->id,
            'hour_id' => $schedulesNextMonthModel->hour_id,
            'date' => $schedulesNextMonthModel->date,
            'status' => $schedulesNextMonthModel->status,
            'tipo' => $schedulesNextMonthModel->tipo,
            'faturado' => $schedulesNextMonthModel->faturado,
            'finalizado_em' => $schedulesNextMonthModel->finalizado_em,
            'data_nao_faturada_id' => $schedulesNextMonthModel->data_mnao_faturada_id,
            'last_login_time' => now(),
            'last_login_ip' => request()->getClientIp(),
            'deleted_by' => auth()->user()->id,
            'scheduleForNextMonth' => 1
        ]);
    }

    /**
     * Handle the schedules next month model "restored" event.
     *
     * @param  \App\Models\SchedulesNextMonthModel  $schedulesNextMonthModel
     * @return void
     */
    public function restored(SchedulesNextMonthModel $schedulesNextMonthModel)
    {
        //
    }

    /**
     * Handle the schedules next month model "force deleted" event.
     *
     * @param  \App\Models\SchedulesNextMonthModel  $schedulesNextMonthModel
     * @return void
     */
    public function forceDeleted(SchedulesNextMonthModel $schedulesNextMonthModel)
    {
        //
    }
}
