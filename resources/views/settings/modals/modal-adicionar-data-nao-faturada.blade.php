<form action="{{ route('settings.salvarDataNaoFaturada') }}" id="form-data-nao-faturada">
    @csrf
    <input type="hidden" name="settings_id" value="{{ $settings_id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Data não faturada:</label>
                <input type="date" name="data" id="data" required class="form-control">
            </div>
        </div>       
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" id="btn-fechar-data-nao-faturada" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-salvar-data-nao-faturada">Salvar</button>
            </div>
        </div>
    </div>
</form>
<script>
    $('#form-data-nao-faturada #btn-salvar-data-nao-faturada').on('click', function(e) {
        if ($('#form-data-nao-faturada #data').val() == '') {
            bootbox.alert({
                title: 'Data não faturada',
                message: 'Preencha o campo data',
                callback: function () {
                    $('#form-data-nao-faturada #data').focus();
                }
            });
            return;
        }
        $.ajax({
            url: $('#form-data-nao-faturada').prop('action'),
            method: 'POST',
            data: $('#form-data-nao-faturada').serialize(),
            beforeSend: function () {
                $('#btn-salvar-data-nao-faturada').html('Salvando <i class="fa fa-spinner fa-spin"></i>')
                $('#btn-salvar-data-nao-faturada').prop('disabled', true);
                $('#btn-fechar-data-nao-faturada').prop('disabled', true);
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#btn-salvar-data-nao-faturada').html('Salvo!');
                    
                    bootbox.alert({
                        title: 'Data não faturada',
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                }
                if (response.status == 'error') {
                    $('#btn-salvar-data-nao-faturada').html('Salvar!');
                    $('#btn-salvar-data-nao-faturada').prop('disabled', false);
                    $('#btn-fechar-data-nao-faturada').prop('disabled', false);

                    bootbox.alert({
                        title: 'Data não faturada',
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script>