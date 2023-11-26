@extends('adminlte::page')

@section('content')
<style>
    .seta::before {
        display: none!important;
    }
    table tbody {
        display: block;
        max-height: 500px;
        overflow: auto;
    }

    table thead, table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
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

        @if ($resetPassWord)
            <div class="alert alert-success">
                <i class="fas fa-info-circle"></i>
                Senha redefinida com sucesso.
            </div>
        @endif

        @if (auth()->user()->is_admin != 1)
        <h4>Bem-vindo(a) <b>{{ auth()->user()->name }}</b></h4>
        @endif

        @php
            $datasNaoFaturadas = \App\Models\DataNaoFaturadaModel::all();
            
            $arrDatas = [];
            foreach ($datasNaoFaturadas as $value) {
                if (\Carbon\Carbon::parse($value->data)->format('m') == date('m')) {
                    $arrDatas[$value->id] = $value->data;
                }
            }
        @endphp

        @if (count($arrDatas) > 0)
            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i>
                As datas abaixo não serão faturadas:
                <ul>
                @foreach ($arrDatas as $value)
                    @if(\Carbon\Carbon::parse($value)->format('Y') == now()->format('Y'))
                    <li>{{ \Carbon\Carbon::parse($value)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</li>
                    @endif
                @endforeach
                </ul>
            </div>
        @endif

        @include('componentes.alerts', [
            'type' => 'alert-info',
            'text' => 'O agendamento só pode ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' da data anterior a escolhida.'
        ])

        {{-- <div class="clearfix">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="user_id_mes_atual" value="{{ $id_user }}">
                <button type="button" class="btn btn-danger" id="btn-cancelar-fixos">Cancelar agendamentos fixos</button>
            </div>
        </div> --}}

        <table class="table table-striped table-hover" id="_tabela-horarios-usuario" style="width:100%">
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
                @php
                    $showStyle = false;
                    if (count($arrDatas) > 0 && isset($arrDatas[$schedule->data_nao_faturada_id])) {
                        $showStyle = true;
                    }
                @endphp
                <tr @if($showStyle) style="background-color: #ffc107" @endif>
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
                                @if ($schedule->status == 'Ativo' || auth()->user()->is_admin == 1)
                                {{-- <a href="#" onclick="faturarFinalizarAtendimento('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Faturar/Finalizar agendamento"><i class="fas fa-hand-holding-usd text-warning"></i> Faturar/Finalizar agendamento</a> --}}
                                <a href="javascript:void(0)" onclick="modalGlobalOpen('{{ route('schedule.modal-cancelar-agendamento-fixo', ['schedule_id' => $schedule->id]) }}', 'Cancelar Agendamento Fixo')" class="dropdown-item btn btn-sm" title="Cancelar agendamento"><i class="fas fa-trash text-danger"></i> Cancelar agendamento</a>
                                {{-- <a href="#" onclick="cancelarAgendamentoUser('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Cancelar agendamento"><i class="fas fa-trash text-danger"></i> Cancelar agendamento</a> --}}
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
                <tr>
                    <td colspan="5">Nenhum horário cadastrado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="clearfix">&nbsp;</div>
        @if (auth()->user()->is_admin == 1)
            <fieldset>
                <legend>Histórico de ações de {{ $username }}</legend>

                <table class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align: center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historic as $item)
                        @php
                            $acao = null; 
                            if ($item->action == 'create') {
                                $acao = "criou";
                            } else if ($item->action == 'delete') {
                                $acao = 'excluiu';
                            } 
                        @endphp

                        <tr>
                            <td>
                                @if ($item->action == 'login')
                                    <strong>{{ $item->user->name }}</strong> realizou <span style="font-weight: bold; color: green">login</span> em {{ $item->lastLogin }}
                                @elseif(is_null($item->scheduleForNextMonth))
                                    @if ($item->action == 'delete' && $item->user_id != $item->deleted_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userHasDelete->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> de <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->roomDeleted->name }} às {{ $item->hour->hour }}
                                    @elseif($item->action == 'create' && $item->user_id != $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> para <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->roomDeleted->name }} às {{ $item->hour->hour }}
                                    @elseif($item->action == 'update' && $item->user_id != $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: orange">atualizou</span> agendamento de <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }} para <strong>{{ $item->tipo }}</strong>
                                    @elseif($item->action == 'update' && $item->user_id == $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: orange">atualizou</span> agendamento para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }} para <strong>{{ $item->tipo }}</strong>
                                    @else
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->user->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }}
                                    @endif
                                @elseif($item->scheduleForNextMonth == 1)
                                    @if ($item->action == 'delete' && $item->user_id != $item->deleted_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userHasDelete->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> de <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->roomDeleted->name }} às {{ $item->hour->hour }}
                                    @elseif($item->action == 'create' && $item->user_id != $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> para <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->roomDeleted->name }} às {{ $item->hour->hour }}
                                    @elseif($item->action == 'update' && $item->user_id != $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: orange">atualizou</span> agendamento de <strong>{{ $item->user->name }}</strong> para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }} para <strong>{{ $item->tipo }}</strong>
                                    @elseif($item->action == 'update' && $item->user_id == $item->created_by)
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->userCreatedBy->name }}</strong> <span style="font-weight: bold; color: orange">atualizou</span> agendamento para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }} para <strong>{{ $item->tipo }}</strong>
                                    @else
                                        Em {{ $item->criadoEm }}, <strong>{{ $item->user->name }}</strong> <span style="font-weight: bold; color: {{ $acao == 'criou' ? 'blue' : 'red' }}">{{ $acao }}</span> agendamento <strong>{{ $item->tipo }}</strong> para o dia {{ $item->data }} na {{ $item->room->name }} às {{ $item->hour->hour }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </fieldset>
        {{-- <fieldset>
            <legend>Horários fixos para o próximo mês</legend>
        
            <div class="clearfix">&nbsp;</div> --}}
            {{-- <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="user_id_proximo_mes" value="{{ $id_user }}">
                    <button type="button" class="btn btn-danger" id="btn-cancelar-fixos-proximo-mes">Cancelar agendamentos - mês de {{ now()->addMonth()->isoFormat('MMMM') }}</button>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div> --}}
            
            {{-- <table class="table table-striped table-hover" id="_tabela-horarios-usuario-proximo-mes" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align: center">Data</th>
                        <th style="text-align: center">Horário</th>
                        <th style="text-align: center">Sala</th>
                        <th style="text-align: center">Tipo de agendamento</th>
                        <th style="text-align: center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedulesNextMonth as $schedule)
                    @php
                        $showStyle = false;
                        if (count($arrDatas) > 0 && isset($arrDatas[$schedule->data_nao_faturada_id])) {
                            $showStyle = true;
                        }
                    @endphp
                    <tr @if($showStyle) style="background-color: #ffc107" @endif>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</td>
                        <td style="text-align: center">{{ $schedule->hour->hour }}</td>
                        <td style="text-align: center">{{ $schedule->room->name }}</td>
                        <td style="text-align: center">{{ $schedule->tipo }}</td>
                        <td style="text-align: center">
                            <div class="btn-group dropleft">
                                <a class="dropdown-toggle seta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu">
                                    @if ($schedule->status == 'Ativo')
                                        <a href="#" onclick="cancelarAgendamentoUserNextMonth('{{ csrf_token() }}', {{ $schedule->id }})" class="dropdown-item btn btn-sm" title="Cancelar agendamento"><i class="fas fa-trash text-danger"></i> Cancelar agendamento</a> --}}
                                        {{-- <a href="#" onclick="mudarTipo('{{ csrf_token() }}', {{ $schedule->id }}, '{{ $schedule->tipo == 'Fixo' ? 'Avulso' : 'Fixo' }}', '{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}', '{{ $schedule->hour->hour }}')" class="dropdown-item btn btn-sm" title="{{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}"><i class="fas fa-exchange-alt text-secondary"></i> {{ $schedule->tipo == 'Fixo' ? 'Mudar para Avulso' : 'Mudar para Fixo' }}</a> --}}
                                    {{-- @else
                                        <a href="#" class="dropdown-item btn btn-sm" title="Nenhuma ação disponível"><i class="fas fa-ban text-secondary"></i> Nenhuma ação disponível</a>
                                    @endif
                                </div>
                            </div>                        
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Nenhum horário cadastrado</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </fieldset>--}}
        @endif
    </div>
</div>

@endsection