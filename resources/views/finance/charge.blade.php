@extends('adminlte::page')

@section('content')
<style>
    .seta::before {
        display: none!important;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div style="display: flex; justify-content: space-between">
            <div>
                <h1>Cobrança</h1>
            </div>
            <div>
                {{-- <div class="float-right"> --}}
                    @if(!empty($clientes))
                    <a href="{{ route('admin.reports.cobranca', ['month' => $_month ?? null, 'year' => $_year ?? null]) }}" class="btn btn-info btn-circle" title="Gerar Relátorio"><i class="fas fa-print" aria-hidden="true"></i></a>
                    @endif
                {{-- </div> --}}
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.finance.search-charges') }}" method="post" class="form-group">
            @csrf
            <input type="hidden" name="reference_month" value="{{ $_month ?? null }}">
            <input type="hidden" name="reference_year" value="{{ $_year ?? null }}">
            <div class="form-row">
                <div class="col-md-2">
                    <label for="">Mês:</label>
                    <select class="form-control" name="month" class="form-control" required>
                        <option value="">-- Selecione --</option>
                        @foreach (getMonths() as $key => $mes)
                        <option value="{{ $key }}" {{ !empty($_month) && $_month == $key ? 'selected' : '' }}>{{ $mes }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="">Ano:</label>
                    <input type="number" min="2018" max="2099" name="year" class="form-control" required step="1" value="{{ !empty($_year) ? $_year : now()->format('Y') }}" />
                </div>
                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-primary form-control">Pesquisar</button>
                </div>
            </div>            
        </form>

        <div style="overflow-x: auto">


        {{-- /*TODO: 
            Pesquisar por mês
            colocar para carregar o mes atual 
            selecionar o o usuario para colocar o valor cobrado e a data do pagamento
            e colocar o status de pagamento
            verificar se tem como colocar no dashboar o status do pagamento do mês que acabou de passar
        */ --}}

        <table class="table table-striped table-bordered table-sm" id="tabela-clientes" style="width: 100%">
            <thead {{-- class="display: table;
            width: 100%;" --}}>
                <tr>
                    <th style="text-align: center" scope="col">Profissional</th>
                    <th style="text-align: center" scope="col">Agendamentos</th>
                    <th style="text-align: center" scope="row">Valor a pagar</th>
                    <th style="text-align: center" scope="col">Valor pago</th>
                    <th style="text-align: center" scope="col">Status</th>
                    <th style="text-align: center" scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($clientes))
                @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->name }}</td>
                    <td class="text-center">{{ $cliente->concluidosAgendamentosMesAnterior }}</td>
                    <td class="text-center">R$ {{ number_format($cliente->totalMesAnterior, 2, ',', '.') }}</td>
                    <td class="text-center">
                        R$ {{ $cliente->fatura_cliente != 0 ? $cliente->fatura_cliente : number_format($cliente->fatura_cliente, 2, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @php
                            $charge = null;
                            $status = [];
                            $status['badge'] = 'warning';
                            $status['descricao'] = 'Pendente';

                            if ($cliente->fatura_cliente != 0 || ($cliente->fatura_cliente == 0 && !empty($cliente->fatura_cliente_id))) {
                                $status['badge'] = 'success';
                                $status['descricao'] = 'Pago';
                            }
                        @endphp
                        <span class="badge badge-pill badge-{{$status['badge']}}">
                            {{ $status['descricao'] }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" title="Registrar pagamento" onclick="modalGlobalOpen(' {{ route('admin.finance.modal-registrar-pagamento', ['cliente_id' => $cliente->id, 'month' => $_month, 'year' => $_year, 'total_a_pagar' => $cliente->totalMesAnterior, 'fatura_cliente_id' => $cliente->fatura_cliente_id ?? null]) }} ', 'Cobrança de {{ getMonths($_month) }} - {{ $cliente->name }}')">
                            <i class="fas fa-hand-holding-usd"></i>
                        </a>
                    </td>
                </tr>
                @empty
                @endforelse
                <tr>
                    <td class="text-center text-bold">Totais:</td>
                    <td class="text-center text-bold">{{ $clientes->sum('concluidosAgendamentosMesAnterior') }}</td>
                    <td class="text-center text-bold">R$ {{ number_format($clientes->sum('totalMesAnterior'), 2, ',', '.') }}</td>
                    <td class="text-center text-bold">R$ {{ number_format($clientes->sum('fatura_cliente'), 2, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection