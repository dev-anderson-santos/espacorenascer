<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\HourModel;
use App\Models\RoomModel;
use App\Models\ChargeModel;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;
use App\Services\ReportsService;
use Illuminate\Support\Collection;

class FinanceController extends Controller
{
    public function index()
    {
        return view('finance.charge');
    }

    public function searchChargesByMonth(Request $request)
    {
        $dados = $request->all();

        $setting = SettingsModel::first();
        $valorFixo = $setting->valor_fixo;
        $valorAvulso = $setting->valor_avulso;
        $taxa = 20; // taxa de 20 reais

        $clientes = User::where('is_admin', '!=', 1)->with('hasAddress')->orderBy('name')->get()->map(function($cliente) use ($valorAvulso, $valorFixo, $dados, $taxa) {
            $concluidosMesAnteriorAvulso = ScheduleModel::where([
                'user_id' => $cliente->id,
                'status' => 'Finalizado',
                'tipo' => 'Avulso',
                'faturado' => 1
            ])
            ->whereMonth('date', $dados['month'])
            ->whereYear('date', $dados['year'])
            ->whereNull('data_nao_faturada_id')
            ->get();

            $concluidosMesAnteriorFixo = ScheduleModel::where([
                        'user_id' => $cliente->id,
                        'status' => 'Finalizado',
                        'tipo' => 'Fixo',
                        'faturado' => 1
                    ])
                    ->whereMonth('date', $dados['month'])
                    ->whereYear('date', $dados['year'])
                    ->whereNull('data_nao_faturada_id')
                    ->get();

            $cliente->concluidosAgendamentosMesAnterior = $concluidosMesAnteriorAvulso->count() + $concluidosMesAnteriorFixo->count();

            // é preciso calcular com o valor fixo e o valor avulso
            // Veirificar se algums horario foi escolhido como avulso
            // $totalAvulsoMesAnterior = 0;
            // if ($concluidosMesAnteriorAvulso->count() > 0) {
            // $totalAvulsoMesAnterior = $concluidosMesAnteriorAvulso->count() * $valorAvulso;
            // }

            // $totalFixoMesAnterior = 0;
            // if ($concluidosMesAnteriorFixo->count() > 0) {
            // $totalFixoMesAnterior = $concluidosMesAnteriorFixo->count() * $valorFixo;
            // }

            $cliente->totalMesAnterior = $concluidosMesAnteriorAvulso->sum('valor') + $concluidosMesAnteriorFixo->sum('valor');
            $cliente->totalMesAnteriorComTaxa = $cliente->totalMesAnterior + $taxa;
            // $cliente->totalMesAnterior = $totalAvulsoMesAnterior + $totalFixoMesAnterior;

            $faturaCliente = ChargeModel::where([
                'user_id' => $cliente->id,
                'reference_month' => $dados['month'],
                'reference_year' => $dados['year']
            ])->first();

            $cliente->fatura_cliente = 0;

            if ($faturaCliente) {
                $cliente->fatura_cliente = $faturaCliente->amount;
                $cliente->fatura_cliente_id = $faturaCliente->id;
            }

            return $cliente;
        })->filter(function($cliente) {
            return $cliente->totalMesAnterior > 0 && $cliente->concluidosAgendamentosMesAnterior > 0;
        });

        // dd($clientes);

        $showSpecificShedule = true;

        return view('finance.charge', [
            'clientes' => $clientes, 
            'showSpecificShedule' => $showSpecificShedule,
            '_month' => $dados['month'],
            '_year' => $dados['year'],
        ]);
    }

    public function modalRegitrarPagamento(Request $request)
    {
        $dados = $request->all();
        
        $clienteCharge = ChargeModel::when(!empty($dados), function ($query) use ($dados) {
            if (isset($dados['fatura_cliente_id'])) {
                $query->where('id', $dados['fatura_cliente_id']);
            } else {
                
                $query->where([
                    'user_id' => $dados['cliente_id'],
                    'reference_month' => $dados['month'],
                    'reference_year' => $dados['year'],
                ]);
            }
        })->first();

        return view('finance.modal.modal-registrar-pagamento', [
            'cliente' => $clienteCharge,
            'user_id' => $dados['cliente_id'],
            'month' => $dados['month'],
            'year' => $dados['year'],
            'total_a_pagar' => $dados['total_a_pagar'],
        ]);
    }

    public function registrarPagamento(Request $request)
    {
        //TODO: \verificar poq está vindo setadgo pago
        $dados = $request->all();
        
        try {
            
            DB::beginTransaction();

            $dados['updated_by'] = auth()->user()->id;
            $dados['reference_month'] = $dados['month'];
            $dados['reference_year'] = $dados['year'];

            $clienteCharge = ChargeModel::where([
                'user_id' => $dados['user_id'],
                'reference_month' => $dados['month'],
                'reference_year' => $dados['year']
            ])->first();

            if ($clienteCharge) {

                $clienteCharge->update($dados);

                DB::commit();

                return response()->json(['status' => 'success', 'message' => 'Cobrança atualizada com sucesso.']);
            }

            $dados['created_by'] = auth()->user()->id;
            $dados['status'] = $dados['status'] ?? 1;
            ChargeModel::create($dados);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Cobrança registrada com sucesso.']);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao salvar a cobrança.', 'messageError' => $e->getMessage()]);
        }
    }

    public function relatorioCobranca(Request $request)
    {
        $clientes = self::searchChargesByMonth($request);
        return ReportsService::gerarRelatorioCobranca($clientes);
    }
}
