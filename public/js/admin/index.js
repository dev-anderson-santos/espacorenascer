$(() => {
    $('#tabela-faturamento-mes-atual').DataTable({
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   true,
        "filter": true,
        "info":     false,
        // "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
        ],
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
        },
    });

    $('#tabela-faturamento-mes-anterior').DataTable({
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   true,
        "filter": true,
        "info":     false,
        // "scrollX": true,
        "columnDefs": [
            // { orderable: false, className: 'reorder', targets: 0 },
            { orderable: false, targets: '_all' }
        ],
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
        },
    });
})