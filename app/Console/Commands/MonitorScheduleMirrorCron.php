<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\HourModel;
use App\Models\ScheduleModel;
use App\Mail\NotifyMirrorEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\ScheduleNextMonthMirrorLog;
use App\Models\DataNaoFaturadaModel;
use Illuminate\Support\Facades\Mail;
use App\Models\SchedulesNextMonthModel;
use Illuminate\Console\Scheduling\Schedule;

class MonitorScheduleMirrorCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:mirror';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Espelhar os agendamentos fixos do mês anterior para o mês atual.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $message = null;
            $schedulesNextMonth = SchedulesNextMonthModel::whereMonth('date', now()->addMonth()->format('m'))
                                ->where('is_mirrored', 1) // Está para ser espelhado
                                ->get();

            if ($schedulesNextMonth->count() == 0) {
                $message = 'Não há agendamentos para espelhar.';

                ScheduleNextMonthMirrorLog::create([
                    'message' => $message,
                    'email' => 'dev.anderson.santos@gmail.com',
                ]);

                DB::commit();
                
                return $this->info($message);
            }

            $arrLastDays = [];
            $arrDados = [];
            foreach ($schedulesNextMonth as $scheduleNext) {

                $schedule_temp = ScheduleModel::where([
                    'user_id' => $scheduleNext->user_id,
                    'room_id' => $scheduleNext->room_id,
                    //'created_by' => $scheduleNext->created_by,
                    'hour_id' => $scheduleNext->hour_id,
                    'date' => $scheduleNext->date,
                    'status' => $scheduleNext->status,
                    'tipo' => $scheduleNext->tipo,
                    'data_nao_faturada_id' => $scheduleNext->data_nao_faturada_id
                ])->first();

                if (empty($schedule_temp)) { // Impedir espelhamento de agendamentos já existentes
                    // ScheduleModel::create([
                    //     'user_id' => $scheduleNext->user_id,
                    //     'room_id' => $scheduleNext->room_id,
                    //     'created_by' => $scheduleNext->created_by,
                    //     'hour_id' => $scheduleNext->hour_id,
                    //     'date' => $scheduleNext->date,
                    //     'status' => $scheduleNext->status,
                    //     'tipo' => $scheduleNext->tipo,
                    //     'data_nao_faturada_id' => $scheduleNext->data_nao_faturada_id,
                    // ]);

                    ScheduleModel::withoutEvents(function() use ($scheduleNext) {

                        // $s = new ScheduleModel();
                        // $s->user_id = $scheduleNext->user_id;
                        // $s->room_id = $scheduleNext->room_id;
                        // $s->created_by = $scheduleNext->created_by;
                        // $s->hour_id = $scheduleNext->hour_id;
                        // $s->date = $scheduleNext->date;
                        // $s->status = $scheduleNext->status;
                        // $s->tipo = $scheduleNext->tipo;
                        // $s->data_nao_faturada_id = $scheduleNext->data_nao_faturada_id;
                        // $s->save();
                        ScheduleModel::create([
                            'user_id' => $scheduleNext->user_id,
                            'room_id' => $scheduleNext->room_id,
                            'created_by' => $scheduleNext->created_by,
                            'hour_id' => $scheduleNext->hour_id,
                            'date' => $scheduleNext->date,
                            'status' => $scheduleNext->status,
                            'tipo' => $scheduleNext->tipo,
                            'data_nao_faturada_id' => $scheduleNext->data_nao_faturada_id,
                        ]);
                    });

                    if (Carbon::parse($scheduleNext->date)->addDays(7) > Carbon::parse($scheduleNext->date)) {
                        $arr = getWeekDays($scheduleNext->date);
                        
                        $newDay = Carbon::parse(last($arr))->addDays(7)->format('Y-m-d');
                        $arrLastDays[] = getWeekDaysNextMonth($newDay);
                        $arrDados[] = [
                            'user_id' => $scheduleNext->user_id,
                            'room_id' => $scheduleNext->room_id,
                            'created_by' => $scheduleNext->created_by,
                            'hour_id' => $scheduleNext->hour_id,
                            'status' => $scheduleNext->status,
                            'tipo' => $scheduleNext->tipo,
                            'is_mirrored' => 1,
                        ];
                    }

                    // $scheduleNext->update(['is_mirrored' => 0]); // Foi espelhado
                    SchedulesNextMonthModel::withoutEvents(function() use ($scheduleNext) {
                        $s = SchedulesNextMonthModel::find($scheduleNext->id);
                        $s->is_mirrored = 0; // Foi espelhado
                        $s->update();
                    });
                }
            }

            foreach ($arrLastDays as $keyExterno => $datas) {
                foreach ($datas as $data) {

                    $dataNaoFaturada = DataNaoFaturadaModel::where('data', $data)->first();
                    if (!is_null($dataNaoFaturada)) {
                        $arrDados[$keyExterno]['data_nao_faturada_id'] = $dataNaoFaturada->id;
                    }

                    $arrDados[$keyExterno]['date'] = $data;
                    $arrDados[$keyExterno]['data_nao_faturada_id'] = NULL;
                    
                    $scheduleNext = SchedulesNextMonthModel::where([
                        'date' => $arrDados[$keyExterno]['date'],
                        'user_id' => $arrDados[$keyExterno]['user_id'],
                        'room_id' => $arrDados[$keyExterno]['room_id'],
                        'created_by' => $arrDados[$keyExterno]['created_by'],
                        'hour_id' => $arrDados[$keyExterno]['hour_id'],
                        'status' => $arrDados[$keyExterno]['status'],
                        'tipo' => $arrDados[$keyExterno]['tipo'],
                        'is_mirrored' => 1,
                    ])->first();

                    if (empty($scheduleNext)) {
                        // SchedulesNextMonthModel::create($arrDados[$keyExterno]);

                        SchedulesNextMonthModel::withoutEvents(function() use ($arrDados, $keyExterno) {
                            // $s = new SchedulesNextMonthModel();
                            // $s->date = $arrDados[$keyExterno]['date'];
                            // $s->user_id = $arrDados[$keyExterno]['user_id'];
                            // $s->room_id = $arrDados[$keyExterno]['room_id'];
                            // $s->created_by = $arrDados[$keyExterno]['created_by'];
                            // $s->hour_id = $arrDados[$keyExterno]['hour_id'];
                            // $s->status = $arrDados[$keyExterno]['status'];
                            // $s->tipo = $arrDados[$keyExterno]['tipo'];
                            // $s->save();
                            SchedulesNextMonthModel::create($arrDados[$keyExterno]);
                        });
                    }
                }
            }

            $message = 'Agendamentos espelhados com sucesso!';

            ScheduleNextMonthMirrorLog::create([
                'message' => $message,
                'email' => 'dev.anderson.santos@gmail.com',
            ]);

            DB::commit();
            
            $this->info($message);

        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao espelhar os agendamentos.');
        }
    }
}
