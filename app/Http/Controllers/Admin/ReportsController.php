<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index()
    {
        return view('administrator.reports.index');
    }

    public function byRooms(Request $request)
    {
        $dados = $request->all();

        // dd($dados);

        $setting = SettingsModel::first();
        $valorFixo = $setting->valor_fixo;
        $valorAvulso = $setting->valor_avulso;

        // TODO: agrupar por mês e sala

        $concluidosMesAnteriorAvulso = ScheduleModel::whereHas('user', function($query) {
            $query->where('email', '!=', 'danielamontechiaregentil@gmail.com');
        })
        ->select('room_id')
        ->where([
            // 'user_id' => $id,
            'status' => 'Finalizado',
            // 'tipo' => 'Avulso',
            // 'faturado' => 1
        ])
        ->whereIn('tipo', ['Fixo', 'Avulso'])
        ->whereMonth('date', $dados['month'] ?? now()->format('m'))
        ->whereYear('date', Carbon::parse($dados['year'])->format('Y') ?? now()->format('y'))
        ->whereNull('data_nao_faturada_id')
        ->get()
        ->groupBy('room_id');

        dd($concluidosMesAnteriorAvulso);
        foreach($concluidosMesAnteriorAvulso as $item) {
            dd($item);
        }

        $concluidosMesAnteriorFixo = ScheduleModel::where([
            // 'user_id' => $id,
            'status' => 'Finalizado',
            'tipo' => 'Fixo',
            'faturado' => 1
        ])
        ->whereMonth('date', Carbon::parse($dados['month'])->format('m'))
        ->whereYear('date', Carbon::parse($dados['year'])->format('Y'))
        ->whereNull('data_nao_faturada_id')
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

        return view('administrator.reports.income-per-room', [
            '_month' => $dados['month'],
            '_year' => $dados['year'],
        ]);
    }
}
