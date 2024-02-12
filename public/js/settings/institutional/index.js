$(function() {

    $('#tabela-imagens-sala').DataTable({
        "order": [[ 2, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   true,
        "filter": false,
        "info":     false,
        "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: true, targets: '_all' }
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

    $('#btn-adicionar-imagem-sala').on('click', function (event) {
        modalGlobalOpen('/app/settings/institutional/modal-adicionar-imagem-institucional?type=create', 'Adicionar Imagem');
    });
})

function deleteInstitutionalImage(image_id) {
    bootbox.confirm({
        title: 'Excluir imagem',
        message: "Deseja realmente excluir esta imagem?",
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
                $.get('/app/settings/institutional/delete-institutional-image', {image_id: image_id}, function(response) {
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
    })
}