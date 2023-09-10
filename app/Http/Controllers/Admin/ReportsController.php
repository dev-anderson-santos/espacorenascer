<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{

    public function yeldsPerPeriodIndex()
    {
        return view('administrator.reports.yelds.per-period');
    }

    public function yeldsPerPeriod(Request $request)
    {
        $dados = $request->all();

        $clientes = User::whereNotIn('id', [1, 2, 5])->orderBy('name')->get()->map(function($cliente) use ($dados) {
            $concluidosMesSelecionadoAvulso = ScheduleModel::selectRaw('user_id, date, count(*), sum(valor)')->where([
                'user_id' => $cliente->id,
                'status' => 'Finalizado',
                'tipo' => 'Avulso'
            ])
            ->whereBetween('date', [$dados['data01'], $dados['data02']])
            ->whereNull('data_nao_faturada_id')
            ->groupBy('user_id','date')
            ->get();

            $concluidosMesSelecionadoFixo = ScheduleModel::selectRaw('user_id, date, count(*) as total_agendamento, sum(valor) as total_valor')->where([
                'user_id' => $cliente->id,
                'status' => 'Finalizado',
                'tipo' => 'Fixo'
            ])
            ->whereBetween('date', [$dados['data01'], $dados['data02']])
            ->whereNull('data_nao_faturada_id')
            ->groupBy('user_id', 'date')
            ->get();

            if ($concluidosMesSelecionadoAvulso->count() > 0 || $concluidosMesSelecionadoFixo->count() > 0) {
                $cliente->concluidosAgendamentosMesSelecionado = $concluidosMesSelecionadoAvulso->sum('total_agendamento') + $concluidosMesSelecionadoFixo->sum('total_agendamento');
                $cliente->totalMesSelecionado = $concluidosMesSelecionadoAvulso->sum('total_valor') + $concluidosMesSelecionadoFixo->sum('total_valor');
            }

            return $cliente;
        })->filter(function($cliente) {
            return $cliente->concluidosAgendamentosMesSelecionado > 0;
        });

        return view('administrator.reports.yelds.per-period', [
            'clientes' => $clientes,
            '_data01' => $dados['data01'],
            '_data02' => $dados['data02'],
        ]);
    }

    public function yeldsPerCustomerIndex()
    {
        return view('administrator.reports.yelds.per-customer');
    }

    public function yeldsPerCustomer(Request $request)
    {
        $dados = $request->all();

        $concluidosMesSelecionado = ScheduleModel::where([
            'user_id' => $dados['user_id'],
            'status' => 'Finalizado',
            // 'faturado' => 1
        ])
        ->whereBetween('date', [$dados['data01'], $dados['data02']])
        ->whereNull('data_nao_faturada_id')
        ->get();

        $qtdAgendamentos = $concluidosMesSelecionado->count();
        $totalValorMesSelecionado = $concluidosMesSelecionado->sum('valor');

        return view('administrator.reports.yelds.per-customer', [
            'user_id' => $dados['user_id'],
            'cliente' => (new User())::find($dados['user_id']),
            'qtdAgendamentos' => $qtdAgendamentos,
            'totalValorMesSelecionado' => $totalValorMesSelecionado,
            '_data01' => $dados['data01'],
            '_data02' => $dados['data02'],
        ]);
    }
}
