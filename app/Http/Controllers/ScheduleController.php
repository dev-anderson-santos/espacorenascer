<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\HourModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    public function userSchedules($user_id = NULL)
    {
        $id = !is_null($user_id) ? $user_id : auth()->user()->id;

        $titulo = !is_null($user_id) && $user_id != auth()->user()->id ? 'Horários Ativos - ' . User::find($id)->name : 'Meus horários Ativos';

        $schedules = ScheduleModel::where([
            'user_id' => $id,
            'faturado' => 0,
        ])
        ->whereMonth('date', Carbon::now()->format('m'))
        ->orderBy('date', 'ASC')->get();

        return view('schedule.my-schedules', compact('schedules', 'titulo'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $schedule = ScheduleModel::all();
        $hours = HourModel::all();
        $rooms = RoomModel::all();

        $dataSelect = [];
        $day = NULL;
        for ($i=0; $i < 7; $i++) {
            if ($i == 0) {
                $day = Carbon::now();
                
            } else {
                $day = Carbon::now()->addDays($i);
            }

            if ($day->isSunday()) {                
                continue;
            }

            array_push($dataSelect, $day);
        }
        // dd($dataSelect);
        $mostrarAgendamento = false;
        if (now()->isBetween(Carbon::parse('07:00')->format('H:i'), Carbon::parse('22:00')->format('H:i'))) {
            $mostrarAgendamento = true;
        }

        return view('schedule.index', compact('hours', 'rooms', 'dataSelect', 'mostrarAgendamento'));
    }

    public function showSpecificShcedule(Request $request)
    {
        $hours = HourModel::all();
        $rooms = RoomModel::all();

        $_day = Carbon::parse($request->day)->format('Y-m-d');
        $schedules = ScheduleModel::where('date', $_day)->get();

        $dataSelect = [];
        $day = NULL;
        for ($i=0; $i < 7; $i++) {
            if ($i == 0) {
                $day = Carbon::now();
                
            } else {
                $day = Carbon::now()->addDays($i);
            }

            if ($day->isSunday()) {                
                continue;
            }

            array_push($dataSelect, $day);
        }

        $showSpecificShedule = true;

        $mostrarAgendamento = false;
        if (now()->isBetween(Carbon::parse('07:00')->format('H:i'), Carbon::parse('22:00')->format('H:i'))) {
            $mostrarAgendamento = true;
        }

        return view('schedule.index', compact('hours', 'rooms', 'dataSelect', 'showSpecificShedule', 'schedules', '_day', 'mostrarAgendamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        try {
            DB::beginTransaction();

            $dia = $dados['date'];

            $dados['status'] = 'Ativo';
            
            $scheduleInUse = ScheduleModel::where([
                'date' => $dados['date'],
                'hour_id' => $dados['hour_id'],
                'room_id' => $dados['room_id'],
            ])->first();

            if($scheduleInUse) {
                return response()->json(['status' => 'warning', 'message' => 'Este horário já está ocupado.']);
            }

            if ($dados['tipo'] == 'Fixo') {                

                $arrDays = [];
                for ($i = Carbon::parse($dia)->weekOfMonth; $i <= Carbon::parse($dia)->endOfMonth()->weekOfMonth; $i++) {
                    if($i == Carbon::parse($dia)->weekOfMonth) {
                        $arrDays[$i] = $dia;

                        if (Carbon::parse($arrDays[$i])->isLastWeek()) {
                            break;
                        }
                    } else {
                        $arrDays[$i] = Carbon::parse($arrDays[$i-1])->addDays(7)->format('Y-m-d');

                        if (Carbon::parse($arrDays[$i])->isLastWeek() || Carbon::parse($arrDays[$i])->isNextMonth()) {
                            unset($arrDays[$i]);
                            break;
                        }
                    }
                }

                $arrDataEmUso = [];
                $horariosEmUso = false;
                foreach ($arrDays as $key => $value) {
                    
                    $dados['date'] = $value;

                    $scheduleInUse = ScheduleModel::where([
                        'date' => $dados['date'],
                        'hour_id' => $dados['hour_id'],
                        'room_id' => $dados['room_id'],
                    ])->first();

                    if($scheduleInUse) {
                        $arrDataEmUso[$key]['data'] = Carbon::parse($value)->isoFormat('dddd, DD \d\e MMMM \d\e Y');
                        $arrDataEmUso[$key]['hora'] = HourModel::where('id', $dados['hour_id'])->first()->hour;
                        $horariosEmUso = true;
                        continue;
                    }

                    ScheduleModel::create($dados);
                }

                DB::commit();
                return response()->json(['status' => 'well-done', 'horariosEmUso' => $horariosEmUso, 'arrDataEmUso' => $arrDataEmUso, 'message' => 'Agendamento realizado com sucesso!']);

            } else {
                ScheduleModel::create($dados);
            }


            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Agendamento realizado com sucesso!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dados = $request->all();
        try {
            DB::beginTransaction();
            $schedule = ScheduleModel::findOrFail($dados['schedule_id']);
    
            $now = Carbon::now()->format('Y-m-d');

            $dateFormated = Carbon::parse($schedule->date)->format('Y-m-d');

            // dd(Carbon::parse($now)->diffInDays($schedule->date, false) <= 1, now()->format('Y-m-d H:i') > Carbon::parse($schedule->date . ' ' . SettingsModel::first()->hora_fechamento)->subDays()->format('Y-m-d H:i'));
            if (Carbon::parse($now)->diffInDays($schedule->date, false) <= 1 && now()->format('Y-m-d H:i') > Carbon::parse($dateFormated . ' ' . SettingsModel::first()->hora_fechamento)->subDays()->format('Y-m-d H:i')) {
            // if ((Carbon::parse($now)->diffInDays($schedule->date, false) <= 1) && (now()->format('H:i') >= Carbon::parse(SettingsModel::first()->hora_fechamento)->format('H:i'))) {
                return response()->json(['status' => 'info', 'message' => 'Este agendamento não pode ser cancelado.']);
            }

            // dd($schedule->date, Carbon::parse($now)->diffInDays($schedule->date, false) <= 1, Carbon::parse('00:00')->format('g:i A') > Carbon::parse(SettingsModel::first()->hora_fechamento)->format('g:i A'));

            $schedule->delete();
    
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Agendamento cancelado com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao cancelar o agendamento.']);
        }

    }

    public function modalSchedule(Request $request)
    {
        $dados = $request->all();

        $hour = HourModel::find($dados['hour_id']);
        $room = RoomModel::find($dados['room_id']);
        $inUse = false;
        $novoAgendamento = false;
        $cancelamento = false;
        $action = 'schedule.destroy';
        $data = $dados['data'];
        $now = Carbon::now()->format('Y-m-d');
        $canCancel = true;

        $schedules = ScheduleModel::where([
            'date' => $dados['data'],
            'hour_id' => $dados['hour_id'],
            'room_id' => $dados['room_id'],
            'user_id' => $dados['user_id'],
        ])->first();
        
        $schedulesB = ScheduleModel::where([
            'date' => $dados['data'],
            'hour_id' => $dados['hour_id'],
            'room_id' => $dados['room_id'],
        ])->first();

        // Verifica se a sala já está em uso pela pessoa logada
        // No horário selecionado
        if (!is_null($schedules)) {
            // Se tiver, retorna o modal de cancelamento
            $inUse = true;
            $cancelamento = true;
            $novoAgendamento = false;

            if ($schedules->status == 'Finalizado') {
                $canCancel = false;
            }

            if (Carbon::parse($now)->diffInDays($schedules->date, false) == 1 && now()->format('H:i') >= SettingsModel::first()->hora_fechamento) {
                if ($schedules->status != 'Finalizado') {
                    $schedules->update([
                        'status' => 'Finalizado',
                    ]);
                }

                $canCancel = false;
            }
            
            return view('schedule.modals.modal-schedule', compact('schedules', 'hour', 'room', 'inUse', 'data', 'cancelamento', 'novoAgendamento', 'action', 'canCancel'));
            
        } else if ($schedules == NULL && !empty($schedulesB)) {
            // Se a sala está em uso por outra pessoa (schedulesB), 
            // retorna a mensagem informando que o horário está ocupado
            $novoAgendamento = false; 
            $cancelamento = false;
            if(auth()->user()->is_admin == 1) {
                $cancelamento = true;
                $action = 'schedule.destroy';

                if ($schedulesB->status == 'Finalizado') {
                    $canCancel = false;
                }
    
                if (Carbon::parse($now)->diffInDays($schedulesB->date, false) == 1 && now()->format('H:i') >= SettingsModel::first()->hora_fechamento) {
                    if ($schedulesB->status != 'Finalizado') {
                        $schedulesB->update([
                            'status' => 'Finalizado',
                        ]);
                    }
    
                    $canCancel = false;
                }

                $schedules = $schedulesB;
            }            

            $inUse = true;           
            return view('schedule.modals.modal-schedule', compact('hour', 'room', 'data', 'inUse', 'novoAgendamento', 'cancelamento', 'action', 'canCancel', 'schedules'));
        } else if (empty($schedules) && empty($schedulesB)) {
            // Se a sala não está em uso, retorna o modal de cadastro
            $inUse = false;
            $novoAgendamento = true;
            $cancelamento = false;
            return view('schedule.modals.modal-schedule', compact('inUse', 'novoAgendamento', 'cancelamento', 'hour', 'room', 'data'));
        }
    }

    public function fechamentosDoMes(Request $request, $user_id = null)
    {
        $id = !is_null($user_id) ? $user_id : auth()->user()->id;

        $user_name = !is_null($user_id) && $user_id != auth()->user()->id ? ' - ' . User::find($id)->name : '';

        $setting = SettingsModel::first();
        $valorFixo = $setting->valor_fixo;
        $valorAvulso = $setting->valor_avulso;

        $concluidosParcialAtivoFixo = ScheduleModel::where([
                        'user_id' => $id,
                        'status' => 'Ativo',
                        'tipo' => 'Fixo'
                    ])
                    ->where('faturado', 0)
                    ->whereMonth('date', Carbon::now()->format('m'))
                    ->get();

        $concluidosParcialAtivoAvulso = ScheduleModel::where([
                        'user_id' => $id,
                        'status' => 'Ativo',
                        'tipo' => 'Avulso'
                    ])
                    ->where('faturado', 0)
                    ->whereMonth('date', Carbon::now()->format('m'))
                    ->get();

        $concluidosParcialFinalizadoFixo = ScheduleModel::where([
                        'user_id' => $id,
                        'status' => 'Finalizado',
                        'tipo' => 'Fixo'
                    ])
                    ->where('faturado', 0)
                    ->whereMonth('date', Carbon::now()->format('m'))
                    ->get();

        $concluidosParcialFinalizadoAvulso = ScheduleModel::where([
                        'user_id' => $id,
                        'status' => 'Finalizado',
                        'tipo' => 'Avulso'
                    ])
                    ->where('faturado', 0)
                    ->whereMonth('date', Carbon::now()->format('m'))
                    ->get();

        $concluidosParcialAgendamentos = $concluidosParcialAtivoFixo->count() + $concluidosParcialAtivoAvulso->count() + $concluidosParcialFinalizadoFixo->count() + $concluidosParcialFinalizadoAvulso->count();

        // $totalParcialAgendamentos = ScheduleModel::where([
        //                 'user_id' => $id,                        
        //                 'status' => 'Ativo',
        //             ])
        //             ->whereMonth('date', Carbon::now()->format('m'))
        //             ->get();
        
        // é preciso calcular com o valor fixo e o valor avulso
        // Veirificar se algums horario foi escolhido como avulso
        $totalAvulso = 0;
        if ($concluidosParcialAtivoAvulso->count() > 0) {
            $totalAvulso = $concluidosParcialAtivoAvulso->count() * $valorAvulso;
        }
        if ($concluidosParcialFinalizadoAvulso->count() > 0) {
            $totalAvulso += $concluidosParcialFinalizadoAvulso->count() * $valorAvulso;
        }

        $totalFixo = 0;
        if ($concluidosParcialAtivoFixo->count() > 0) {
            $totalFixo = $concluidosParcialAtivoFixo->count() * $valorFixo;
        }
        if ($concluidosParcialFinalizadoFixo->count() > 0) {
            $totalFixo += $concluidosParcialFinalizadoFixo->count() * $valorFixo;
        }

        $totalParcialValor = $totalAvulso + $totalFixo;

        //---- Mês anterior

        $concluidosMesAnteriorAvulso = ScheduleModel::where([
            'user_id' => $id,
            'status' => 'Finalizado',
            'tipo' => 'Avulso',
            'faturado' => 1
        ])
        ->whereIn('tipo', ['Fixo', 'Avulso'])
        ->whereMonth('date', Carbon::now()->firstOfMonth()->subMonths()->format('m'))
        ->get();

        $concluidosMesAnteriorFixo = ScheduleModel::where([
                    'user_id' => $id,
                    'status' => 'Finalizado',
                    'tipo' => 'Fixo',
                    'faturado' => 1
                ])
                ->whereMonth('date', Carbon::now()->firstOfMonth()->subMonths()->format('m'))
                ->get();

        $concluidosAgendamentosMesAnterior = $concluidosMesAnteriorAvulso->count() + $concluidosMesAnteriorFixo->count();

        // é preciso calcular com o valor fixo e o valor avulso
        // Veirificar se algums horario foi escolhido como avulso
        $totalAvulsoMesAnterior = 0;
        if ($concluidosMesAnteriorAvulso->count() > 0) {
        $totalAvulsoMesAnterior = $concluidosMesAnteriorAvulso->count() * $valorAvulso;
        }

        $totalFixoMesAnterior = 0;
        if ($concluidosMesAnteriorFixo->count() > 0) {
        $totalFixoMesAnterior = $concluidosMesAnteriorFixo->count() * $valorFixo;
        }

        $totalMesAnterior = $totalAvulsoMesAnterior + $totalFixoMesAnterior;

        return view('fechamentos-mes.index', 
            compact(
                'id',
                'user_name', 
                'concluidosParcialAgendamentos', 
                'totalParcialValor', 
                'concluidosAgendamentosMesAnterior', 
                'totalMesAnterior'
            ));
    }

    public function mudarTipoAgendamento(Request $request)
    {
        $dados = $request->all();

        try {
            DB::beginTransaction();
            $schedule = ScheduleModel::findOrFail($dados['schedule_id']);

            $tipo = $schedule->tipo == 'Fixo' ? 'Avulso' : 'Fixo';

            if ($tipo == 'Fixo') {   
                
                $schedule->update([
                    'tipo' => $tipo
                ]);

                $dados['user_id'] = $schedule->user_id;
                $dados['created_by'] = auth()->user()->id;
                $dados['hour_id'] = $schedule->hour_id;
                $dados['room_id'] = $schedule->room_id;

                $arrDays = [];
                for ($i = Carbon::parse($schedule->date)->weekOfMonth; $i <= Carbon::parse($schedule->date)->endOfMonth()->weekOfMonth; $i++) {
                    if($i == Carbon::parse($schedule->date)->weekOfMonth) {
                        $arrDays[$i] = $schedule->date;

                        if (Carbon::parse($arrDays[$i])->isLastWeek()) {
                            break;
                        }
                    } else {
                        $arrDays[$i] = Carbon::parse($arrDays[$i-1])->addDays(7)->format('Y-m-d');

                        if (Carbon::parse($arrDays[$i])->isLastWeek() || Carbon::parse($arrDays[$i])->isNextMonth()) {
                            unset($arrDays[$i]);
                            break;
                        }
                    }
                }

                $arrDataEmUso = [];
                $horariosEmUso = false;
                foreach ($arrDays as $key => $value) {
                    
                    $dados['date'] = $value;

                    $scheduleInUse = ScheduleModel::where([
                        'date' => $dados['date'],
                        'hour_id' => $schedule->hour_id,
                        'room_id' => $schedule->room_id,
                    ])->first();

                    if($scheduleInUse) {
                        $arrDataEmUso[$key]['data'] = Carbon::parse($value)->isoFormat('dddd, DD \d\e MMMM \d\e Y');
                        $arrDataEmUso[$key]['hora'] = HourModel::where('id', $schedule->hour_id)->first()->hour;
                        $horariosEmUso = true;
                        continue;
                    }

                    $dados['tipo'] = $tipo;

                    ScheduleModel::create($dados);
                }

                DB::commit();
                return response()->json(['status' => 'well-done', 'horariosEmUso' => $horariosEmUso, 'arrDataEmUso' => $arrDataEmUso, 'message' => 'Agendamento realizado com sucesso!']);
            }

            $schedule->update([
                'tipo' => $tipo
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Tipo de agendamento alterado com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao mudar o tipo de agendamento.']);
        }
    }

    public function updateAllSchedules(Request $request)
    {
        try {
            DB::beginTransaction();

            $schedules = ScheduleModel::where('status', '!=', 'Finalizado')->where('user_id', auth()->user()->id)->get();
            $now = Carbon::now()->format('Y-m-d');

            foreach ($schedules as $schedule) {
                // dump($schedule->date);
                if (Carbon::parse($now)->diffInDays($schedule->date, false) < 1 && now()->format('H:i') >= SettingsModel::first()->hora_fechamento) {
                    // dd('teste');
                    $schedule->update([
                        'status' => 'Finalizado'
                    ]);
                }        
            }
            // dd('teste');

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Horários atualizados com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao atualizar os horários.']);
        }

    }

    public function details(Request $request)
    {
        $dados = $request->all();

        $schedulesToShow = null;

        $schedulesToShow = ScheduleModel::where('user_id', $dados['user_id'])->where('faturado', 1)->whereIn('status', ['Ativo', 'Finalizado'])->whereMonth('date', Carbon::now()->firstOfMonth()->subMonths()->format('m'))->get();

        if ($dados['schedule_type'] == 'MES_ATUAL') {
            $schedulesToShow = ScheduleModel::where('user_id', $dados['user_id'])->where('faturado', 0)->whereIn('status', ['Ativo', 'Finalizado'])->whereMonth('date', Carbon::now()->format('m'))->get();
        }

        // dd($schedulesToShow);

        return view('schedule.modals.modal-detalhes-mes', compact('schedulesToShow'));
    }
}
