@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Painel de Controle</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">

        <h4>Bem-vindo(a) <b>{{ auth()->user()->name }}</b></h4>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Usuários ativos - {{ now()->isoFormat('MMMM') }}</span>
                        <span class="info-box-number">{{ $activeUsers }} de {{ $users->count() }} cadastrados</span>
                    </div>            
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total de agendamentos - {{ now()->isoFormat('MMMM') }}</span>
                        <span class="info-box-number">{{ $totalSchedulesInMonth }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-hand-holding-usd"></i></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">A receber em - {{ now()->isoFormat('MMMM') }}</span>
                        <span class="info-box-number">R$ {{ number_format($clientesMesAtual->sum('totalParcialValor'), 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-money-bill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Recebido em - {{ now()->subMonths()->isoFormat('MMMM') }}</span>
                        <span class="info-box-number">R$ {{ number_format($clientesMesAnterior->sum('totalMesAnterior'), 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>            
        </div>

        <fieldset>
            <legend>Faturamento - {{ now()->isoFormat('MMMM') }}</legend>
            <div class="clearfix">&nbsp;</div>
            <table class="table table-striped table-bordered table-sm" id="tabela-faturamento-mes-atual" style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align: center" scope="col">Nome</th>
                        <th style="text-align: center" scope="col">Agendamentos</th>
                        {{-- <th style="text-align: center" scope="col">Situação</th> --}}
                        <th style="text-align: center" scope="col">Total a pagar parcial</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientesMesAtual as $item)
                    <tr>
                        <td class="text-left">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->concluidosParcialAgendamentos }}</td>
                        {{-- <td class="text-center"><span class="badge badge-danger">Atrasado</span></td> --}}
                        <td class="text-center">R$ {{ number_format($item->totalParcialValor, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>

        <fieldset>
            <legend>Faturamento - {{ now()->subMonths()->isoFormat('MMMM') }}</legend>
            <div class="clearfix">&nbsp;</div>
            <table class="table table-striped table-bordered table-sm" id="tabela-faturamento-mes-anterior" style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align: center" scope="col">Nome</th>
                        <th style="text-align: center" scope="col">Agendamentos</th>
                        {{-- <th style="text-align: center" scope="col">Situação</th> --}}
                        <th style="text-align: center" scope="col">Total a pagar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientesMesAnterior as $item)
                    <tr>
                        <td class="text-left">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->concluidosAgendamentosMesAnterior }}</td>
                        {{-- <td class="text-center"><span class="badge badge-danger">Atrasado</span></td> --}}
                        <td class="text-center">R$ {{ number_format($item->totalMesAnterior, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>
    </div>
</div>
@endsection