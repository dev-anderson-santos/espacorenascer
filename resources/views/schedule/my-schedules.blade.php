@extends('adminlte::page')

@section('content')
<style>
    .seta::before {
        display: none!important;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $titulo }} ({{ $schedules->count() }})</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">

        <h4>Bem-vindo(a) <b>{{ auth()->user()->name }}</b></h4>

        @include('componentes.alerts', [
            'type' => 'alert-info',
            'text' => 'O agendamento só pode ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' da data anterior a escolhida.'
        ])

        <table class="table table-striped table-bordered table-sm" id="tabela-horarios-usuario" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: center">Data</th>
                    <th style="text-align: center">Horário</th>
                    <th style="text-align: center">Sala</th>
                    <th style="text-align: center">Tipo de agendamento</th>
                    {{-- <th>Status</th> --}}
                    {{-- @if (auth()->user()->is_admin == 1) --}}
                    <th style="text-align: center">Ações</th>
                    {{-- @endif --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                <tr>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</td>
                    <td style="text-align: center">{{ $schedule->hour->hour }}</td>
                    <td style="text-align: center">{{ $schedule->room->name }}</td>
                    <td style="text-align: center">{{ $schedule->tipo }}</td>
                    {{-- <td>{{ $schedule->status }}</td> --}}
                    {{-- @if (auth()->user()->is_admin == 1) --}}
                    <td style="text-align: center">
                        <div class="btn-group dropleft">
                            <a class="dropdown-toggle seta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu">
                                {{-- <a href="#" onclick="naoFaturarAgendamento('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Não faturar agendamento"><i class="fas fa-coins text-danger"></i> Não faturar agendamento</a> --}}
                                @if ($schedule->status == 'Ativo')
                                {{-- <a href="#" onclick="faturarFinalizarAtendimento('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Faturar/Finalizar agendamento"><i class="fas fa-hand-holding-usd text-warning"></i> Faturar/Finalizar agendamento</a> --}}
                                <a href="#" onclick="cancelarAgendamentoUser('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Cancelar agendamento"><i class="fas fa-trash text-danger"></i> Cancelar agendamento</a>
                                <a href="#" onclick="mudarTipo('{{ csrf_token() }}', {{ $schedule->id }}, '{{ $schedule->tipo == 'Fixo' ? 'Avulso' : 'Fixo' }}', '{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}', '{{ $schedule->hour->hour }}')" class="dropdown-item btn btn-sm" title="{{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}"><i class="fas fa-exchange-alt text-secondary"></i> {{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}</a>
                                @else
                                <a href="#" class="dropdown-item btn btn-sm" title="Nenhuma ação disponível"><i class="fas fa-ban text-secondary"></i> Nenhuma ação disponível</a>
                                @endif
                            </div>
                        </div>                        
                    </td>                        
                    {{-- @endif --}}
                </tr>
                @empty
                {{-- <tr>
                    <td colspan="5">Nenhum horário cadastrado</td>
                </tr> --}}
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection