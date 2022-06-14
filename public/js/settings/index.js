$(function() {

    $('#tabela-datas-nao-faturadas').DataTable({
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
        } else [
            bootbox.alert(response.message)
        ]
    });
}