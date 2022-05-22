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
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   true,
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
    bootbox.confirm({
        title: 'Mudar tipo do Agendamento',
        message: "Tem certeza que quer mudar para <b>" + tipo + "</b> o tipo do agendamento reservado para " + data + " às " + hora + "?",
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

function faturarFinalizarAtendimento(token, scheduleID) {
    // bootbox.confirm({
    //     title: 'Faturar/Finalizar atendimento',
    //     message: "Deseja realmente faturar o atendimento?",
    //     buttons: {
    //         confirm: {
    //             label: 'Sim',
    //             className: 'btn-success'
    //         },
    //         cancel: {
    //             label: 'Não',
    //             className: 'btn-secondary'
    //         }
    //     },
    //     callback: function (result) {
    //         if (result) {
    //             $.ajax({
    //                 url: '/app/schedule/faturar-finalizar-atendimento',
    //                 method: 'POST',
    //                 data: {
    //                     _token: token,
    //                     schedule_id: scheduleID != '' ? scheduleID : -1,
    //                 },
    //                 success: function(response) {
    //                     if (response.status == 'success') {
    //                         bootbox.alert({
    //                             title: 'Faturar/Finalizar atendimento',
    //                             message: response.message,
    //                             callback: function () {
    //                                 location.reload();
    //                             }
    //                         });
    //                     } else {
    //                         bootbox.alert({
    //                             title: 'Informação',
    //                             message: response.message
    //                         });
    //                     }                        
    //                 }
    //             });
    //         }
    //     }
    // });
}

function naoFaturarAgendamento(token, scheduleID) {
    // bootbox.confirm({
    //     title: 'Não faturar agendamento',
    //     message: "Deseja realmente não faturar o agendamento?",
    //     buttons: {
    //         confirm: {
    //             label: 'Sim',
    //             className: 'btn-success'
    //         },
    //         cancel: {
    //             label: 'Não',
    //             className: 'btn-secondary'
    //         }
    //     },
    //     callback: function (result) {
    //         if (result) {
    //             $.ajax({
    //                 url: '/app/schedule/nao-faturar-agendamento',
    //                 method: 'POST',
    //                 data: {
    //                     _token: token,
    //                     schedule_id: scheduleID != '' ? scheduleID : -1,
    //                 },
    //                 success: function(response) {
    //                     if (response.status == 'success') {
    //                         bootbox.alert({
    //                             title: 'Não faturar agendamento',
    //                             message: response.message,
    //                             callback: function () {
    //                                 location.reload();
    //                             }
    //                         });
    //                     } else {
    //                         bootbox.alert({
    //                             title: 'Informação',
    //                             message: response.message
    //                         });
    //                     }                        
    //                 }
    //             });
    //         }
    //     }
    // });
}