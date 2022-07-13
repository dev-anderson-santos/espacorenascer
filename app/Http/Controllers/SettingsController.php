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
}
