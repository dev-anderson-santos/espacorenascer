$(function() {

    $('#tabela-datas-nao-faturadas').DataTable({
        "order": [[ 0, "desc" ]],
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

    $('#btn-adicionar-data-nao-faturada').on('click', function (event) {

        var arrPost = {
            '_token': $('#form-settings [name="_token"]').val(),
            'settingsID': $('#form-settings [name="id"]').val(),
            'valor_fixo': $('#form-settings [name="valor_fixo"]').val(),
            'valor_avulso': $('#form-settings [name="valor_avulso"]').val(),
            'hora_fechamento': $('#form-settings [name="hora_fechamento"]').val(),
            'dia_fechamento': $('#form-settings [name="dia_fechamento"]').val()
        }

        $.get('/app/settings/update-settings-ajax', arrPost, function(response) {
            modalGlobalOpen('/app/settings/modal-adicionar-data-nao-faturada/?settings_id=' + response.settings_id, 'Adicionar Data Não Faturada');            
        });
    });

    $('#btn-faturar-agendamento').on('click', function (event) {
        bootbox.confirm({
            title: "Faturar Agendamentos",
            message: "Deseja realmente faturar todos os agendamentos?<br/><br/>Os agendamentos com datas inferiores a data atual, serão faturados.<br/><br/> <span class='text-danger'><b>Esta ação não poderá ser desfeita.</b></span>",
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
                    $.get('/app/settings/faturar-agendamentos', {}, function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message,
                                callback: function() {
                                    location.reload();
                                }
                            });
                        } else {
                            bootbox.alert(response.message)
                        }
                    });
                }
            }
        });
    });

    $('#btn-espelhar-agendamentos').on('click', function (event) {
        bootbox.confirm({
            title: "Espalhar Agendamentos",
            message: "Deseja realmente espelhar todos os agendamentos?<br/><br/> <span class='text-danger'><b>Esta ação não poderá ser desfeita.</b></span>",
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
                    $.get('/app/settings/espelhar-agendamentos', {}, function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message,
                                callback: function() {
                                    location.reload();
                                }
                            });
                        } else if (response.status == 'info') {
                            bootbox.alert(response.message)
                        } else {
                            bootbox.alert(response.message)
                            console.log(response.erro);
                        }
                    });
                }
            }
        });
    });

    $('#btn-excluir-agendamentos-espelhados').on('click', function (event) {
        bootbox.confirm({
            title: "Excluir Agendamentos",
            message: "Deseja realmente excluir todos os agendamentos espelhados?<br/><br/> <span class='text-danger'><b>Esta ação não poderá ser desfeita.</b></span>",
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
                    $.get('/app/settings/excluir-agendamentos-espelhados', {}, function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message,
                                callback: function() {
                                    location.reload();
                                }
                            });
                        } else {
                            bootbox.alert(response.message)
                        }
                    });
                }
            }
        });
    });

    $('#btn-update-schedules-price-manually').on('click', function (event) {
        bootbox.confirm({
            title: "Atualizar Valor dos Agendamentos",
            message: "Deseja realmente atualizar os valores de todos os agendamentos?<br/><br/> <span class='text-danger'></span>",
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
                    $.get('/app/settings/update-schedules-price-manually', {valorFixo: 19.00, valorAvulso: 19.00}, function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message,
                                callback: function() {
                                    location.reload();
                                }
                            });
                        } else {
                            bootbox.alert(response.message)
                            console.log('DEBUG: '+ response.messageDebug);
                        }
                    });
                }
            }
        });
    });

    $('#btn-excluir-agendamentos-duplicados').on('click', function (event) {
        bootbox.confirm({
            title: "Excluir Agendamentos duplicados",
            message: "Deseja realmente excluir todos os agendamentos duplicados?<br/><br/> <span class='text-danger'><b>Esta ação não poderá ser desfeita.</b></span>",
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
                    $.get('/app/settings/delete-duplicated-schedules', {}, function(response) {
                        if (response.status == 'success') {
                            bootbox.alert({
                                title: 'Informação',
                                message: response.message,
                                callback: function() {
                                    location.reload();
                                }
                            });
                        } else {
                            bootbox.alert(response.message)
                            console.log(response.messageDebug);
                        }
                    });
                }
            }
        });
    });

    $('#btn-sync-dates').on('click', function () {
        $(this).prop('disabled', true);
        $(this).html('Sincronizando <i class="fa fa-spinner fa-spin"></i>');
        $.get($(this).data('url'), function (response) {
            if (response.status == 'success') {
                // $('#btn-sync-dates').remove('<i class="fa fa-spinner fa-spin"></i>')
                $('#btn-sync-dates').html('Datas sincronizadas');
                bootbox.alert({
                    title: 'Informação',
                    message: response.message,
                    callback: function() {
                        location.reload();
                    }
                });
            } else {
                bootbox.alert({
                    title: 'Informação',
                    message: response.message
                });
            }
        })
    });

})

function removerDataNaoFaturada(data_nao_faturada_id) {
    $.get('/app/settings/remover-data-nao-faturada', {data_nao_faturada_id: data_nao_faturada_id}, function(response) {
        if (response.type == 'success') {
            bootbox.alert({
                title: 'Informação',
                message: response.message,
                callback: function() {
                    location.reload();
                }
            });
        } else {
            bootbox.alert(response.message)
        }
    });
}