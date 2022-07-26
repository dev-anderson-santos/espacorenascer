<?php

namespace App\Console\Commands;

use App\Models\DataNaoFaturadaModel;
use Carbon\Carbon;
use App\Models\HourModel;
use App\Models\ScheduleModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
            
            $schedulesNextMonth = SchedulesNextMonthModel::whereMonth('date', now()->addMonth()->format('m'))->get();

            if ($schedulesNextMonth->count() == 0) {
                return $this->info('Não há agendamentos para o mês seguinte.');
            }

            $arrLastDays = [];
            $arrDados = [];
            foreach ($schedulesNextMonth as $scheduleNext) {
                if ($scheduleNext->is_mirrored != 1) {
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

                    if (Carbon::parse($scheduleNext->date)->addDays(7)->format('m') > Carbon::parse($scheduleNext->date)->format('m')) {
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

                    SchedulesNextMonthModel::create($arrDados[$keyExterno]);
                }
            }

            DB::commit();
            
            $this->info('Agendamentos espalhados com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao espelhar os agendamentos.');
        }
    }
}
