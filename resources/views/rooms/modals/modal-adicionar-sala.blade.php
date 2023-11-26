<form action="{{ route($action) }}" method="POST">
    @csrf
    <input type="hidden" name="room_id" value="{{ $room->id ?? '' }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nome:</label>
                <input type="text" name="name" class="form-control" placeholder="Informe o nome da sala" value="{{ $room->name ?? '' }}">
            </div>
        </div>       
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btn-salvar-sala">Salvar</button>
            </div>
        </div>
    </div>
</form>