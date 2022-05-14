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

        $titulo = !is_null($user_id) && $user_id != auth()->user()->id ? 'Horários - ' . User::find($id)->name : 'Meus horários';

        $schedules = ScheduleModel::where('user_id', $id)->orderBy('date', 'ASC')->get();

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

            if ((Carbon::parse($now)->diffInDays($schedule->date, false) <= 1) && (/* now()->format('H:i') */'23:00' >= Carbon::parse(SettingsModel::first()->hora_fechamento)->format('H:i'))) {
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
            $canCancel = true;

            $now = Carbon::now()->format('Y-m-d');

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
            $inUse = true;           
            return view('schedule.modals.modal-schedule', compact('hour', 'room', 'data', 'inUse', 'novoAgendamento', 'cancelamento'));
        } else if (empty($schedules) && empty($schedulesB)) {
            // Se a sala não está em uso, retorna o modal de cadastro
            $inUse = false;
            $novoAgendamento = true;
            $cancelamento = false;
            return view('schedule.modals.modal-schedule', compact('inUse', 'novoAgendamento', 'cancelamento', 'hour', 'room', 'data'));
        }
    }

    public function fechamentosDoMes(Request $request)
    {
        // Listtar dois meses
        // Agrupar por mes, depois por tipo, somando cada um e colocar o total
        // No botão detalhes, abrir um modal com uma tabela listando:
        // - Profissional, Tipo de atendimento, Dia da semana, Horário, Sala, Created_at

        // $dados = $request->all();

        // $id = !is_null($dados['user_id']) ? $dados['user_id'] : auth()->user()->id;

        // $titulo = !is_null($dados['user_id']) && $dados['user_id'] != auth()->user()->id ? 'Horários - ' . User::find($id)->name : 'Meus horários';

        $setting = SettingsModel::first();
        $valorFixo = $setting->valor_fixo;
        $valorAvulso = $setting->valor_avulso;

        $mesAtual = ScheduleModel::where([
                        'user_id' => auth()->user()->id,
                        'date' => Carbon::now()->format('Y-m-d'),
                    ])->first()->date;

        $totalMesAtualFixo = ScheduleModel::where([
                        'user_id' => auth()->user()->id,
                        // 'date' => Carbon::now()->format('Y-m-d'),
                        'tipo' => 'Fixo',
                    ])->get()->count();

        $totalMesAtualAvulso = ScheduleModel::where([
                        'user_id' => auth()->user()->id,
                        // 'date' => Carbon::now()->format('Y-m-d'),
                        'tipo' => 'Avulso',
                    ])->get()->count();

        return view('fechamentos-mes.index', compact('mesAtual', 'totalMesAtualFixo', 'totalMesAtualAvulso', 'valorFixo', 'valorAvulso'));

        // $mesAnterior = ScheduleModel::select('date', '*')
        //             ->where([
        //                 'user_id' => auth()->user()->id,
        //                 'date' => Carbon::now()->format('m'),
        //             ])->first();
        
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
                if (Carbon::parse($now)->diffInDays($schedule->date, false) < 1 && '23:00' >= SettingsModel::first()->hora_fechamento) {
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
}
