<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataNaoFaturadaModel;
use App\Models\SchedulesNextMonthModel;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = SettingsModel::first();
        $datas_nao_faturadas = DataNaoFaturadaModel::all();
        return view('settings.index', compact('setting', 'datas_nao_faturadas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            SettingsModel::find($request->id)->update($request->all());

            DB::commit();
            return redirect()->route('settings.index')->with(['success' => true, 'message' => 'Configurações atualizadas com sucesso!']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('settings.index')->with(['error' => true, 'message' => 'Ocorreu um erro ao atualizar as configurações!']);
        }
    }

    public function updateSettingsAjax(Request $request)
    {
        try {
            DB::beginTransaction();

            $settings = SettingsModel::find($request->settingsID);
            $settings->update([
                'valor_fixo' => $request->valor_fixo,
                'valor_avulso' => $request->valor_avulso,
                'hora_fechamento' => $request->hora_fechamento,
                'dia_fechamento' => $request->dia_fechamento,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'settings_id' => $settings->id,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(['error' => true, 'message' => 'Ocorreu um erro ao atualizar as configurações!']);
        }
    }

    public function modalAdicionarDataNaoFaturada(Request $request)
    {        
        return view('settings.modals.modal-adicionar-data-nao-faturada', ['settings_id' => SettingsModel::find($request->settings_id)]);
    }

    public function adicionarDataNaoFaturada(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataNaoFaturada = DataNaoFaturadaModel::create($request->all());
            $schedules = ScheduleModel::all();
            $schedulesNextMonth = SchedulesNextMonthModel::all();

            foreach($schedules as $schedule) {
                if (Carbon::parse($schedule->date)->format('Y-m-d') == Carbon::parse($dataNaoFaturada->data)->format('Y-m-d')) {
                    $schedule->update([
                        'data_nao_faturada_id' => $dataNaoFaturada->id,
                    ]);
                }
            }

            foreach($schedulesNextMonth as $schedule) {
                if (Carbon::parse($schedule->date)->format('Y-m-d') == Carbon::parse($dataNaoFaturada->data)->format('Y-m-d')) {
                    $schedule->update([
                        'data_nao_faturada_id' => $dataNaoFaturada->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('settings.index')->with(['success' => true, 'message' => 'Data adicionada com sucesso!']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('settings.index')->with(['error' => true, 'message' => 'Ocorreu um erro ao adicionar a data não faturada!']);
        }
    }

    public function removerDataNaoFaturada(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataNaoFaturada = DataNaoFaturadaModel::find($request->data_nao_faturada_id);
            $schedules = ScheduleModel::all();
            $schedulesNextMonth = SchedulesNextMonthModel::all();

            foreach($schedules as $schedule) {
                if ($schedule->data_nao_faturada_id == $dataNaoFaturada->id) {
                    $schedule->update([
                        'data_nao_faturada_id' => null,
                    ]);
                }
            }

            foreach($schedulesNextMonth as $schedule) {
                if ($schedule->data_nao_faturada_id == $dataNaoFaturada->id) {
                    $schedule->update([
                        'data_nao_faturada_id' => null,
                    ]);
                }
            }

            $dataNaoFaturada->delete();

            DB::commit();

            return response()->json(['type' => 'success', 'message' => 'Data removida com sucesso!']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(['type' => 'error', 'message' => 'Ocorreu um erro ao remover a data!']);
        }
    }

    public function faturar()
    {
        try {
            DB::beginTransaction();

            $schedules = ScheduleModel::where('status', 'Finalizado')
                ->where('faturado', '!=', 1)
                ->whereBetween('date', [
                    now()->subMonth()->startOfMonth()->format('Y-m-d'),
                    now()->subMonth()->endOfMonth()->format('Y-m-d')
                ])->get();

            foreach ($schedules as $schedule) {
                $schedule->update([
                    'faturado' => 1
                ]);      
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Agendamentos faturados com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao faturar os agendamentos!']);
        }
    }

    public function mirror()
    {
        try {
            DB::beginTransaction();

            $schedulesNextMonth = SchedulesNextMonthModel::whereMonth('date', now()->addMonth()->format('m'))->get();

            if ($schedulesNextMonth->count() == 0) {
                return response()->json(['status' => 'info', 'message' => 'Não há agendamentos para espelhar para o mês seguinte.']);
            }

            $arrLastDays = [];
            $arrDados = [];
            foreach ($schedulesNextMonth as $scheduleNext) {
                if ($scheduleNext->is_mirrored != 1) {
                    
                    $schedule_temp = ScheduleModel::where([
                        'user_id' => $scheduleNext->user_id,
                        'room_id' => $scheduleNext->room_id,
                        'created_by' => $scheduleNext->created_by,
                        'hour_id' => $scheduleNext->hour_id,
                        'date' => $scheduleNext->date,
                        'status' => $scheduleNext->status,
                        'tipo' => $scheduleNext->tipo,
                        'data_nao_faturada_id' => $scheduleNext->data_nao_faturada_id
                    ])->first();

                    if (empty($schedule_temp)) {
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
                        SchedulesNextMonthModel::create($arrDados[$keyExterno]);
                    }                    
                }
            }

            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Agendamentos espalhados com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao espalhar os agendamentos!', 'erro' => $e->getMessage()]);
        }
    }

    public function deleteMirroredSchedules()
    {
        try {
            DB::beginTransaction();
            
            SchedulesNextMonthModel::whereMonth('date', now()->addMonth()->format('m'))->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Agendamentos excluídos com sucesso!']);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao excluir os agendamentos!']);
        }
    }
}
