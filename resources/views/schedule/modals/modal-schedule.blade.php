@if ($novoAgendamento || $cancelamento)
<div class="row">
    <div class="col-md-6">
        @if(auth()->user()->is_admin != 1 || $cancelamento)
        <span style="font-weight: 800;">Profissional:</span> {{ !empty($schedules) ? $schedules->user->name : auth()->user()->name }}
        <input type="hidden" id="user-not-admin-id" value="{{ auth()->user()->id }}">
        @elseif ($novoAgendamento && auth()->user()->is_admin == 1)
        <span style="font-weight: 800;">Profissional:</span>
        <select class="form-control" name="user" id="user-id">
            @foreach (\App\User::all() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Sala:</span> {{ $room->name ?? '' }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Data:</span> {{ \Carbon\Carbon::parse($data)->isoFormat('dddd, DD \d\e MMMM \d\e Y') ?? '' }}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Horário:</span> {{ $hour->hour ?? '' }}
    </div>
</div>
@if (!empty($schedules))
<div class="row">
    <div class="col-md-12 {{ $cancelamento ? 'text-danger' : '' }}">
        <span style="font-weight: 800;">Criado em:</span> {{ \Carbon\Carbon::parse($schedules->created_at)->format('d/m/Y H:i:s') ?? '' }}
    </div>
</div>
<div class="row">
    <div class="col-md-12 {{ $cancelamento ? 'text-danger' : '' }}">
        <span style="font-weight: 800;">Criado por:</span> {{ !empty($schedules) ? $schedules->createdBy->name : '' }}
    </div>
</div>
@endif
<form action="" method="post">
    <input type="hidden" id="schedule" value="{{ !empty($schedules) ? $schedules->id : '' }}">
    @if ($cancelamento)
        <input type="hidden" name="action" value="{{ $action }}">
    @endif
    <input type="hidden" name="cancelamento" value="{{ $cancelamento ?? '' }}">
    <div class="row">
        <div class="col-md-12 {{ $cancelamento ? 'text-danger' : '' }}">
            <span style="font-weight: 800;">Tipo de agendamento:</span> {{ $cancelamento ? (!empty($schedules) ? $schedules->tipo : '') : '' }}
        </div>
    </div>
    @if (!$cancelamento)
        <div class="row">
            <div class="col-md-6">
                <select class="form-control" name="" id="type-schedule">
                    <option value="Avulso">Avulso</option>
                    <option value="Fixo">Fixo</option>
                </select>
            </div>
        </div>  
        <div class="clearfix">&nbsp;</div>
        <div class="alert alert-warning" style="font-size: 15pt" role="alert">
            <i class="fas fa-info-circle"></i> Verifique todos os dados antes de confirmar o agendamento.
        </div>
        @php
            $dataSelecionada = \Carbon\Carbon::parse($data)->subDays(2)->format('Y-m-d');
            $dataNow = \Carbon\Carbon::now()->format('Y-m-d');
            $horaAtual = \Carbon\Carbon::now()->format('H:i');
            $horaSetted = \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->format('H:i');
        @endphp
        @if (!empty($schedules) && $schedules->status == 'Finalizado'
            || \Carbon\Carbon::parse($dataNow)->diffInDays($data, false) <= 1 && now()->format('Y-m-d H:i') > \Carbon\Carbon::parse($data . ' ' . $horaSetted)->subDays()->format('Y-m-d H:i')
            )
            @include('componentes.alerts', [
                'type' => 'alert-danger',
                'text' => 'Este agendamento não poderá ser cancelado.',
                'smallText' => 'O agendamento só pode ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' da data anterior a escolhida.'
            ])
        @else
            @include('componentes.alerts', [
                'type' => 'alert-danger',
                'text' => 'Este agendamento poderá ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' do dia ' . \Carbon\Carbon::parse($data)->subDays(1)->format('d/m/Y') . '.'
            ]) 
        @endif
           
        <div class="clearfix">&nbsp;</div>  
    @endif
    @if ($cancelamento && auth()->user()->is_admin != 1)
        <div class="clearfix">&nbsp;</div>
        @if (!$canCancel)
            @include('componentes.alerts', [
                'type' => 'alert-danger',
                'text' => 'Este agendamento não pode mais ser cancelado.',
                'smallText' => 'O agendamento só pode ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' da data anterior a escolhida.'
            ])
        @else
            @include('componentes.alerts', [
                'type' => 'alert-danger',
                'text' => 'Este agendamento poderá ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' do dia ' . \Carbon\Carbon::parse($data)->subDays(1)->format('d/m/Y') . '.'
            ])
        @endif        
    @endif
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal">Fechar</button>
        @if ($cancelamento)
            @if($canCancel)
                <input type="hidden" class="tipo-agendamento" value="{{ $schedules->tipo }}">
                <button type="button" class="btn btn-danger" id="btn-cancelar-agendamento">Cancelar Agendamento</button>
            @endif
        @else
            <button type="button" class="btn btn-primary" id="agendar">Agendar</button>
        @endif
    </div>
</form>

@elseif(empty($schedule) && (isset($inUse) && $inUse == true))
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;" class="text-danger">Este horário não está disponível.</span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>      
</div>
@endif

<script>
$('#agendar').on('click', function () {
    $.ajax({
        url: '{{ route('schedule.store') }}',
        method: 'POST',
        data: {
            room_id: {{ $room->id }},
            hour_id: {{ $hour->id }},
            user_id: $('#user-id').val() || $('#user-not-admin-id').val(),
            date: $('#data-agendamento').val(),
            created_by: {{ auth()->user()->id }},
            tipo: $('#type-schedule').val(),
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function () {
            $('#agendar').prop('disabled', true);
            $('#agendar').html('Agendando <i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(response) {
            if(response.status == 'success') {
                $('#agendar').html('Agendado!');
                bootbox.alert({
                    title: 'Informação',
                    message: response.message,
                    callback: function () {
                        location.reload();
                    }
                });
            } else if (response.status == 'warning') {
                bootbox.alert(response.message);
                $('#agendar').html('Agendar');
                $('#agendar').prop('disabled', true);
                $('#agendar').remove('i');
            } else if (response.status == 'well-done') {
                $('#agendar').html('Agendado!');
                if (response.horariosEmUso) {
                    var dados = '';
                    $.each(response.arrDataEmUso, function(index, horario) {
                        // console.log(horario.data);
                        dados += '<tr><td>' + horario.hora + '</td><td>' + horario.data + '</td></tr>'
                    })
                    bootbox.confirm({
                        title: 'Agendamento realizado com sucesso!',
                        message: `
                        <div class="alert alert-info" style="font-size: 15pt" role="alert">
                            <i class="fas fa-info-circle"></i> Os seguintes horários não foram agendados pois já estavam ocupados.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Horario</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        ${dados}
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>`,
                        buttons: {
                            confirm: {
                                label: 'Sim',
                                className: 'btn-success'
                            },
                            cancel: {
                                label: 'Não',
                                className: 'btn-danger'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                location.reload();
                            } else {
                                $('#agendar').html('Agendar');
                                $('#agendar').prop('disabled', false);
                                $('#agendar').remove('i');
                            }
                        }
                    });
                } else {
                    bootbox.alert({
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                }
                console.log(response.message);
            } else if (response.status == 'error') {
                $('#agendar').html('Não Agendado!');
                bootbox.alert('Ocorreu um erro ao agendar o horário!');
                console.log(response.message);
            }
        }
    });
});

$('#btn-cancelar-agendamento').on('click', function () {
    if ($('.tipo-agendamento').val() == 'Fixo') {
        modalGlobalOpen(`/app/schedule/modal-cancelar-agendamento-fixo/?schedule_id=${$('#schedule').val()}`, 'Cancelar Agendamento Fixo');
    } else {
        bootbox.confirm({
            title: 'Cancelar Agendamento',
            message: "Deseja realmente cancelar o agendamento?<br> Esta ação não poderá ser desfeita!",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-secondary'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: '/app/schedule/to-destroy-schedule',
                        method: 'POST',
                        data: {
                            schedule_id: $('#schedule').val() != '' ? $('#schedule').val() : -1,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $('#btn-cancelar-agendamento').prop('disabled', true);
                            $('#btn-fechar').prop('disabled', true);
                            $('#btn-cancelar-agendamento').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#btn-cancelar-agendamento').html('Cancelado!');
                                
                                bootbox.alert({
                                    title: 'Cancelamento',
                                    message: response.message,
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            } else if (response.status == 'info') {
                                $('#btn-cancelar-agendamento').prop('disabled', false);
                                $('#btn-fechar').prop('disabled', false);
                                $('#btn-cancelar-agendamento').html('Não cancelado!');

                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message,
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                $('#btn-cancelar-agendamento').prop('disabled', false);
                                $('#btn-fechar').prop('disabled', false);
                                $('#btn-cancelar-agendamento').html('Não cancelado!');

                                bootbox.alert({
                                    title: 'Erro',
                                    message: response.message
                                });
                            } 
                        }
                    });
                }
            }
        });
    }
});
</script>