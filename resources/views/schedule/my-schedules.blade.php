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
                <h1>{{ $titulo }}</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">

        <h4>Bem-vindo(a) <b>{{ auth()->user()->name }}</b></h4>

        <table class="table table-striped" id="tabela-horarios-usuario">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Sala</th>
                    <th>Tipo de agendamento</th>
                    <th>Status</th>
                    @if (auth()->user()->is_admin == 1)
                    <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</td>
                    <td>{{ $schedule->hour->hour }}</td>
                    <td>{{ $schedule->room->name }}</td>
                    <td>{{ $schedule->tipo }}</td>
                    <td>{{ $schedule->status }}</td>
                    @if (auth()->user()->is_admin == 1)
                    <td>
                        <div class="btn-group dropleft">
                            <a class="dropdown-toggle seta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="#" onclick="cancelarAgendamentoUser('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Cancelar agendamento"><i class="fas fa-trash text-danger"></i> Cancelar agendamento</a>
                                <a href="#" onclick="mudarTipo('{{ csrf_token() }}', {{ $schedule->id }}, '{{ $schedule->tipo == 'Fixo' ? 'Avulso' : 'Fixo' }}', '{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}', '{{ $schedule->hour->hour }}')" class="dropdown-item btn btn-sm" title="{{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}"><i class="fas fa-exchange-alt text-secondary"></i> {{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}</a>
                            </div>
                        </div>                        
                    </td>                        
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5">Nenhum horário cadastrado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection