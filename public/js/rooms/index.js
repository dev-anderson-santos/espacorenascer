$(function() {

    $('#btn-adicionar-sala').on('click', function (event) {
        modalGlobalOpen('/app/rooms/modal-adicionar-sala', 'Adicionar Sala');
    });
});

function editarSala(room_id) {    
    modalGlobalOpen('/app/rooms/modal-editar-sala/' + room_id, 'Editar Sala');
}

function removerSala(room_id) {
    $.get('/app/rooms/verificar-sala-em-uso/', {id: room_id}, function(response) {
        if (response.status == 'true') {
            
            bootbox.confirm({
                title: "Remover Sala",
                message: "Deseja realmente remover esta sala?<br/><br/> <span class='text-danger'><b>Esta ação não poderá ser desfeita.</b></span>",
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
                        $.get('/app/rooms/remover-sala', {id: room_id}, function(response) {
                            if (response.status == 'success') {
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message,
                                    callback: function() {
                                        location.reload();
                                    }
                                });
                            } 
                            if (response.status == 'error') {
                                bootbox.alert({
                                    title: 'Informação',
                                    message: response.message
                                });
                            }
                        });
                    }
                }
            });
        }

        if (response.status == 'false') {
            bootbox.alert({
                title: 'Informação',
                message: response.message
            });
        }
    });
}