@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Rendimento por período</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.reports.yield-per-period') }}" method="post" class="form-group">
            @csrf
            {{-- <input type="hidden" name="date01" value="{{ $_date01 ?? null }}">
            <input type="hidden" name="date02" value="{{ $_date02 ?? null }}"> --}}
            <div class="form-row">
                {{-- <div class="col-md-2">
                    <label for="">Mês:</label>
                    <select class="form-control" name="month01" class="form-control" required>
                        <option value="">-- Selecione --</option>
                        @foreach (getMonths() as $key => $mes)
                        <option value="{{ $key }}" {{ !empty($_month) && $_month == $key || empty($_month) && $key == now()->format('m') ? 'selected' : '' }}>{{ $mes }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-md-2">
                    <label for="">De:</label>
                    <input type="date" name="data01" class="form-control" required step="1" value="{{ !empty($_data01) ? $_data01 : now()->format('Y-m-d') }}" />
                </div>
                {{-- <div class="col-md-2">
                    <label for="">Mês:</label>
                    <select class="form-control" name="month02" class="form-control" required>
                        <option value="">-- Selecione --</option>
                        @foreach (getMonths() as $key => $mes)
                        <option value="{{ $key }}" {{ !empty($_month) && $_month == $key || empty($_month) && $key == now()->format('m') ? 'selected' : '' }}>{{ $mes }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-md-2">
                    <label for="">Até:</label>
                    <input type="date" name="data02" class="form-control" required step="1" value="{{ !empty($_data02) ? $_data02 : now()->format('Y-m-d') }}" />
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
        @if(!empty($clientes))
            <table class="table table-striped table-bordered table-sm" style="width: 100%">
                <thead {{-- class="display: table;
                width: 100%;" --}}>
                    <tr>
                        <th style="text-align: center" scope="col">Total de Clientes</th>
                        <th style="text-align: center" scope="col">Agendamentos</th>
                        <th style="text-align: center" scope="col">Total</th>
                    </tr>
                </thead>
                <tbody {{-- class="display: table;
                width: 100%;" --}}>
                    @if(!empty($clientes))
                    <tr>
                        <td class="text-center text-bold">{{ $clientes->sum('totalClientes') }}</td>
                        <td class="text-center text-bold">{{ $clientes->sum('concluidosAgendamentosMesSelecionado') }}</td>
                        <td class="text-center text-bold">R$ {{ number_format($clientes->sum('totalMesSelecionado'), 2, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @if (!empty($_data02) && $_data02 > now()->format('Y-m-d'))
                <span style="font-weight: bolder;">O resultado da pesquisa exibe somente os agendamentos que já aconteceram até a data {{ now()->format('d/m/Y') }}.</span>
            @endif
        @endif
        </div>
    </div>
</div>

@endsection