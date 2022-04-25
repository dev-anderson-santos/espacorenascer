$(function() {
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