@include('componentes.alerts', [
    'type' => 'alert-danger',
    'text' => $message,
    // 'smallText' => 'O agendamento só pode ser cancelado até às '. \Carbon\Carbon::parse(\App\Models\SettingsModel::first()->hora_fechamento)->isoFormat('H\h') .' da data anterior a escolhida.'
])

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal">Fechar</button>
</div>