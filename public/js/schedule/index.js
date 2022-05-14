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

    // $('#tabela-horarios-usuario').DataTable({
    //     "order": [[ 0, "asc" ]],
    //     "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
    //     "paging":   false,
    //     "filter": false,
    //     "info":     false,
    //     "scrollX": true,
    //     "columnDefs": [
    //         // { orderable: false, className: 'reorder', targets: 0 },
    //         { orderable: false, targets: '_all' }
    //     ],
    // });

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

// function tick() {
//     //get the mins of the current time
//     var mins = new Date().getMinutes();
//     var sec = new Date().getSeconds();
//     if (mins == "46" && sec == "30") {
    
//         $.ajax({
//             url: '/app/schedule/update-all-schedules',
//             method: 'GET',
//             success: function(response) {
//                 if (response.status == 'success') {
//                     console.log(response.message);
//                     location.reload();
//                 }
//             }
//         })
//     }
//     console.log('Tick ' + mins + ':' + sec);
// }