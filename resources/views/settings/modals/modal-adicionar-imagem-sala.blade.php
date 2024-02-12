<form action="{{ route($route) }}" method="post" enctype="multipart/form-data" id="form-imagem-institucional">
    @csrf
    <input type="hidden" value="{{ $model->id ?? '' }}" name="id">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="description">Descrição:</label>
                <input type="text" name="description" id="description" placeholder="Ex: Sala 01" value="{{{ $model->description ?? '' }}}" required class="form-control">
            </div>
        </div>       
        <div class="col-md-12">
            <div class="form-group">
                <label for="image">Selecione uma imagem:</label>
                <input type="file" name="image" id="image" {{ !empty($model) ? '' : 'required' }} class="form-control" accept=".png, .jpg, .jpeg">
            </div>
        </div>       
        <div class="col-md-12">
            <div class="form-group">
                <label for="order_image">Ordem da imagem na listagem:</label>
                <input type="number" name="order_image" min="0" id="order_image" title="Informe a posição da imagem" value="{{ $model->order_image ?? 0 }}" required class="form-control" accept=".png, .jpg, .jpeg">
            </div>
        </div>       
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" id="btn-fechar-imagem-institucional" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btn-salvar-imagem-institucional">Salvar</button>
            </div>
        </div>
    </div>
</form>
<script>
    $('#form-imagem-institucional').on('submit', function(e) {

        var formData = new FormData();
        formData.append('description', $('#description'));
        formData.append('image', $('#image'));
        formData.append('order_image', $('#order_image'));
        
        $.ajax({
            url: $('#form-imagem-institucional').attr('action'),
            method: 'POST',
            data: formData,
            beforeSend: function () {
                $('#btn-salvar-imagem-institucional').html('Salvando <i class="fa fa-spinner fa-spin"></i>')
                $('#btn-salvar-imagem-institucional').prop('disabled', true);
                $('#btn-fechar-imagem-institucional').prop('disabled', true);
            },
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            },
            success: function(response) {

                console.log(response.status);
                if (response.status == 'success') {
                    $('#btn-salvar-imagem-institucional').html('Salvo!');
                    
                    bootbox.alert({
                        title: 'Informação',
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                }
                if (response.status == 'warning') {
                    $('#btn-salvar-imagem-institucional').html('Salvar!');
                    $('#btn-salvar-imagem-institucional').prop('disabled', false);
                    $('#btn-fechar-imagem-institucional').prop('disabled', false);

                    bootbox.alert({
                        title: 'Informação',
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                }
                if (response.status == 'error') {
                    $('#btn-salvar-imagem-institucional').html('Salvar!');
                    $('#btn-salvar-imagem-institucional').prop('disabled', false);
                    $('#btn-fechar-imagem-institucional').prop('disabled', false);

                    bootbox.alert({
                        title: 'Informação',
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