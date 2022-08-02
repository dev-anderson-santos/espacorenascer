$(function() {
    // 
    $('#tabela-clientes').DataTable({
        // "order": [[ 0, "asc" ]],
        "bLengthChange": false, // Oculta o campo Show [10, 15,...] entries
        "paging":   false,
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


    $('.cpf').mask('000.000.000-00', {
        reverse: true
    });

    $('.cpf').on( 'keyup' , function()
    {
        let $cpf = $( this );
        let cpf  = $cpf.val().replace( /[^\d]+/g , '' );

        if ( cpf.length != 11) return false;

        if( !validarCPF( cpf ) ) {
            $('.hint-cpf').show()
            $('.hint-cpf').text('CPF: ' + $cpf.val() + ' inválido');
            $('#btn-salvar-usuario').prop('disabled', true);
            $(this).addClass('is-invalid');          
        } else {
            $('.hint-cpf').hide()
            $('#btn-salvar-usuario').prop('disabled', false);
            $(this).removeClass('is-invalid');
            $(this).css('border-color','#d1d3e2');
        }
        $('.cpf-group .invalid-feedback').hide()
    } );
})