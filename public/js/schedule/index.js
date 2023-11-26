$(function() {

    $('#schedule-table').DataTable({
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   false,
        "filter": false,
        "info":     false,
        "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
        ],
    });

    $('#tabela-horarios-usuario').DataTable({
        "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   false,
        "filter": false,
        "info":     false,
        "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
        ],
        "language": {
            "zeroRecords": "Nenhum dado encontrado.",
            "infoEmpty": "Nenhum dado encontrado.",
            "info": "Mostrando página _START_ de _END_ de _TOTAL_ registros.",
            "paginate": {
                "previous": "Anterior",
                "next": "Próximo",
              }
        },
    });

    $('#tabela-horarios-usuario-proximo-mes').DataTable({
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   false,
        "filter": false,
        "info":     false,
        "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
        ],
        "language": {
            "zeroRecords": "Nenhum dado encontrado.",
            "infoEmpty": "Nenhum dado encontrado.",
            "info": "Mostrando página _START_ de _END_ de _TOTAL_ registros.",
            "paginate": {
                "previous": "Anterior",
                "next": "Próximo",
              }
        },
    });

    // setInterval(tick, 1000);
    $('#btn-cancelar-fixos').on('click', function () {
        bootbox.confirm({
            title: 'Cancelar Todos os Agendamentos',
            message: "Deseja realmente cancelar todos os <b>Agendamentos Fixos disponíveis</b>?<br> Esta ação não poderá ser desfeita!",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-danger ok'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-secondary not-ok'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: '/app/schedule/cancel-all-fixed-schedules/'+$('#user_id_mes_atual').val(),
                        method: 'POST',
                        data: {
                            _token: $('[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function () {
                            $('.ok').prop('disabled', true);
                            $('.not-ok').prop('disabled', true);
                            $('.ok').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('.ok').html('Cancelado!');
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message,
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                $('.ok').prop('disabled', false);
                                $('.not-ok').prop('disabled', false);
                                $('.ok').html('Cancelar');
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message
                                });
                            }                        
                        }
                    });
                }
            }
        });
    });

    $('#btn-cancelar-fixos-proximo-mes').on('click', function () {
        bootbox.confirm({
            title: 'Cancelar Agendamentos - Para o Próximo Mês',
            message: "Deseja realmente cancelar todos os <b>Agendamentos Para o Próximo Mês</b>?<br> Esta ação não poderá ser desfeita!",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-danger ok'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-secondary not-ok'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: '/app/schedule/cancel-all-fixed-next-month-schedules/'+$('#user_id_proximo_mes').val(),
                        method: 'POST',
                        data: {
                            _token: $('[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function () {
                            $('.ok').prop('disabled', true);
                            $('.not-ok').prop('disabled', true);
                            $('.ok').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('.ok').html('Cancelado!');
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message,
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                $('.ok').prop('disabled', false);
                                $('.not-ok').prop('disabled', false);
                                $('.ok').html('Cancelar');
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message
                                });
                            }                        
                        }
                    });
                }
            }
        });
    });
});


function cancelarAgendamentoUser (token, scheduleID) {
    bootbox.confirm({
        title: 'Cancelar Agendamento',
        message: "Deseja realmente cancelar o agendamento?<br> Esta ação não poderá ser desfeita!",
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-danger ok'
            },
            cancel: {
                label: 'Não',
                className: 'btn-secondary not-ok'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: '/app/schedule/to-destroy-schedule',
                    method: 'POST',
                    data: {
                        _token: token,
                        schedule_id: scheduleID != '' ? scheduleID : -1,
                    },
                    beforeSend: function () {
                        $('.ok').prop('disabled', true);
                        $('.not-ok').prop('disabled', true);
                        $('.ok').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.ok').html('Cancelado!');
                            bootbox.alert({
                                title: 'Cancelamento',
                                message: response.message,
                                callback: function () {
                                    location.reload();
                                }
                            });
                        } else {
                            $('.ok').prop('disabled', false);
                            $('.not-ok').prop('disabled', false);
                            $('.ok').html('Cancelar');
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message
                            });
                        }                        
                    }
                });
            }
        }
    });
}

function mudarTipo(token, scheduleID, tipo, data, hora) {
    var observacao = tipo == 'Avulso' ? ' <br><br><p>Os agendamentos <strong>Fixos</strong> subsequentes a este das semanas seguintes serão cancelados. </p><span style="color: #f00; font-weight:800">Esta ação não poderá ser desfeita.</span>' : ''; 
    bootbox.confirm({
        title: 'Mudar tipo do Agendamento',
        message: "Tem certeza que deseja mudar para <b>" + tipo + "</b> o tipo do agendamento reservado para <strong>" + data + " às " + hora + "</strong>?" + observacao,
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-warning'
            },
            cancel: {
                label: 'Não',
                className: 'btn-secondary'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: '/app/schedule/mudar-tipo-agendamento',
                    method: 'POST',
                    data: {
                        _token: token,
                        schedule_id: scheduleID != '' ? scheduleID : -1,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Mudar tipo de agendamento',
                                message: response.message,
                                callback: function () {
                                    location.reload();
                                }
                            });
                        } else if (response.status == 'well-done') {
                            $('#agendar').html('Agendado!');
                            if (response.horariosEmUso) {
                                var dados = '';
                                $.each(response.arrDataEmUso, function(index, horario) {
                                    // console.log(horario.data);
                                    dados += '<tr><td>' + horario.hora + '</td><td>' + horario.data + '</td></tr>'
                                })
                                bootbox.alert({
                                    title: 'Mudar tipo de agendamento',
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
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message,
                                    callback: function () {
                                        location.reload();
                                    }
                                });
                            }
                            console.log(response.message);
                        } else {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message
                            });
                        }                        
                    }
                });
            }
        }
    });
}

function cancelarAgendamentoUserNextMonth (token, scheduleID) {
    bootbox.confirm({
        title: 'Cancelar Agendamento',
        message: "Deseja realmente cancelar este agendamento para o próximo mês?<br> Esta ação não poderá ser desfeita!",
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-danger ok'
            },
            cancel: {
                label: 'Não',
                className: 'btn-secondary not-ok'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: '/app/schedule/destroy-schedule-next-month',
                    method: 'POST',
                    data: {
                        _token: token,
                        schedule_id: scheduleID != '' ? scheduleID : -1,
                    },
                    beforeSend: function () {
                        $('.ok').prop('disabled', true);
                        $('.not-ok').prop('disabled', true);
                        $('.ok').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.ok').html('Cancelado!');
                            bootbox.alert({
                                title: 'Cancelamento',
                                message: response.message,
                                callback: function () {
                                    location.reload();
                                }
                            });
                        } else {
                            $('.ok').prop('disabled', false);
                            $('.not-ok').prop('disabled', false);
                            $('.ok').html('Cancelar');
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message
                            });
                        }                        
                    }
                });
            }
        }
    });
}