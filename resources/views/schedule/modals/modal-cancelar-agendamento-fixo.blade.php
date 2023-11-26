
<div class="row">
    <div class="col-md-12">
        <p>Deseja realmente cancelar o agendamento reservado para <strong>{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</strong>?
        @if ($schedule->tipo == 'Fixo')
        <p>Os agendamentos <b>fixos</b> subsequentes a este das semanas seguintes serão cancelados.</p>
        @endif
        <br><span style="color: #f00; font-weight:800">Esta ação não poderá ser desfeita.</span>
    </div>
</div>


@if($nextWeekDays > 0 && $schedule->tipo == 'Fixo')
    @if ($otherWeekSchedules->count() > 0 || $otherWeekSchedulesNextMonth->count() > 0)
    <div style="display: none;">
        <div class="row">
            <div class="col-md-12">
                <p>Os seguintes agendamentos também serão cancelados:</p>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Sala</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($otherWeekSchedules as $item)
                    <tr>
                        <input type="hidden" class="otherWeekSchedules" value="{{ $item->id }}">
                        <td>{{ \Carbon\Carbon::parse($item->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</td>
                        <td>{{ $item->hour->hour }}</td>
                        <td>{{ $item->room->name ?? '' }}</td>
                    </tr>
                @endforeach
                @foreach ($otherWeekSchedulesNextMonth as $item)
                    <tr>
                        <input type="hidden" class="otherWeekSchedulesNextMonth" value="{{ $item->id }}">
                        <td>{{ \Carbon\Carbon::parse($item->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}</td>
                        <td>{{ $item->hour->hour }}</td>
                        <td>{{ $item->room->name ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endif

<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="action" value="{{ $action }}">
            <input type="hidden" id="schedule_id" value="{{ $schedule->id }}">
            <input type="hidden" id="schedule_tipo" value="{{ $schedule->tipo }}">
            <button type="button" class="btn btn-secondary" id="btn-fechar-cancelar-agendamento-fixo" onclick="$('#modalGlobal').modal('hide'); $('.modal-footer').remove()">Não</button>
            <button type="button" class="btn btn-danger" id="btn-cancelar-agendamento-fixo">Sim</button>
        </div>
    </div>
</div>
<script>
    $('#btn-cancelar-agendamento-fixo').on('click', function () {

        var action = $('#action').val();
        var token = '{{ csrf_token() }}';
        var schedule_id = $('#schedule_id').val();
        var otherWeekSchedules = $('.otherWeekSchedules').map(function () {
            return $(this).val();
        }).get();
        var otherWeekSchedulesNextMonth = $('.otherWeekSchedulesNextMonth').map(function () {
            return $(this).val();
        }).get();

        if ($('#schedule_tipo').val() == 'Fixo') {
            $.ajax({
                url: action,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    schedule_id: schedule_id,
                    otherWeekSchedules: otherWeekSchedules,
                    otherWeekSchedulesNextMonth: otherWeekSchedulesNextMonth,
                },
                beforeSend: function () {
                    $('#btn-cancelar-agendamento-fixo').prop('disabled', true);
                    $('#btn-fechar-cancelar-agendamento-fixo').prop('disabled', true);
                    $('#btn-cancelar-agendamento-fixo').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('btn-cancelar-agendamento-fixo').html('Cancelado!');
                        bootbox.alert({
                            title: 'Cancelamento',
                            message: response.message,
                            callback: function () {
                                location.reload();
                            }
                        });
                    } else {
                        $('#btn-cancelar-agendamento-fixo').prop('disabled', false);
                        $('#btn-fechar-cancelar-agendamento-fixo').prop('disabled', false);
                        $('#btn-cancelar-agendamento-fixo').html('Sim');
                        bootbox.alert({
                            title: 'Informação',
                            message: response.message
                        });

                        console.log(response.error);
                    }                        
                }
            });
        } else {
            $.ajax({
                url: action,
                method: 'POST',
                data: {
                    _token: token,
                    schedule_id: schedule_id
                },
                beforeSend: function () {
                    $('#btn-cancelar-agendamento-fixo').prop('disabled', true);
                    $('#btn-fechar-cancelar-agendamento-fixo').prop('disabled', true);
                    $('#btn-cancelar-agendamento-fixo').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#btn-cancelar-agendamento-fixo').html('Cancelado!');
                        bootbox.alert({
                            title: 'Cancelamento',
                            message: response.message,
                            callback: function () {
                                location.reload();
                            }
                        });
                    } else {
                        $('#btn-cancelar-agendamento-fixo').prop('disabled', false);
                        $('#btn-fechar-cancelar-agendamento-fixo').prop('disabled', false);
                        $('#btn-cancelar-agendamento-fixo').html('Sim');
                        bootbox.alert({
                            title: 'Informação',
                            message: response.message
                        });

                        console.log(response.error);
                    }                        
                }
            });
        }
    });
</script>
