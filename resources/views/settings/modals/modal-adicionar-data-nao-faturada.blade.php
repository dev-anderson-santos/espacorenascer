<form action="{{ route('settings.adicionarDataNaoFaturada') }}" method="POST">
    @csrf
    <input type="hidden" name="settings_id" value="{{ $settings_id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Data não faturada:</label>
                <input type="date" name="data" class="form-control">
            </div>
        </div>       
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btn-salvar-data-nao-faturada">Salvar</button>
            </div>
        </div>
    </div>
</form>