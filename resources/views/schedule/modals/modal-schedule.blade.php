@if ($novoAgendamento || $cancelamento)
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Profissional:</span> {{ !empty($schedules) ? $schedules->user->name : auth()->user()->name }}
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
        <span style="font-weight: 800;">Criado em:</span> {{ \Carbon\Carbon::parse($schedules->created_at)->isoFormat('dddd, DD \d\e MMMM \d\e Y') ?? '' }}
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
    @endif
    @if ($cancelamento)
        @include('componentes.alerts', [
            'type' => 'alert-danger',
            'text' => 'O agendamento poderá ser cancelado em até 24 horas de antecedência!'
        ])
    @endif
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal">Fechar</button>
        @if ($cancelamento)
            <button type="button" class="btn btn-danger" id="btn-cancelar-agendamento">Cancelar Agendamento</button>
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
            user_id: {{ auth()->user()->id }},
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
                location.reload();
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
                    bootbox.alert(response.message);
                    location.reload();
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
                        $('#agendar').prop('disabled', true);
                        $('#btn-fechar').prop('disabled', true);
                        $('#agendar').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(data) {
                        $('#agendar').html('Cancelado!');
                        console.table(data);
                        location.reload();
                    }
                });
            }
        }
    });
});
</script>