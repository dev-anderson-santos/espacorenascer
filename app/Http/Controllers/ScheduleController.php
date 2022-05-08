<?php

namespace App\Http\Controllers;

use App\Models\DayOfWeekModel;
use App\Models\HourModel;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use Illuminate\Support\Facades\DB;
use App\Models\ScheduleHourDayModel;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    public function mySchedules()
    {
        $schedules = ScheduleModel::where('user_id', auth()->user()->id)->get();

        // Listtar dois meses
        // Agrupar por mes, depois por tipo, somando cada um e colocar o total
        // No botão detalhes, abrir um modal com uma tabela listando:
        // - Profissional, Tipo de atendimento, Dia da semana, Horário, Sala, Created_at

        return view('schedule.my-schedules', compact('schedules'));
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
        for ($i=0; $i < 28; $i++) {
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

        return view('schedule.index', compact('hours', 'rooms', 'dataSelect'));
    }

    public function showSpecificShcedule(Request $request)
    {
        $hours = HourModel::all();
        $rooms = RoomModel::all();

        $_day = Carbon::parse($request->day)->format('Y-m-d');
        $schedules = ScheduleModel::where('date', $_day)->get();

        $dataSelect = [];
        $day = NULL;
        for ($i=0; $i < 28; $i++) {
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

        return view('schedule.index', compact('hours', 'rooms', 'dataSelect', 'showSpecificShedule', 'schedules', '_day'));
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

            $dados['status'] = 'Ocupado';
            
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    
            $schedule->delete();
    
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Agendamento cancelado com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
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
            
            return view('schedule.modals.modal-schedule', compact('schedules', 'hour', 'room', 'inUse', 'data', 'cancelamento', 'novoAgendamento', 'action'));
            
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
}
