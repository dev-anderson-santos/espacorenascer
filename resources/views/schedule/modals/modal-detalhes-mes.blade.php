
@forelse ($schedulesToShow as $item)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Nº:</span> {{ $loop->index + 1 }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Profissional:</span> {{ $item->user->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Tipo de agendamento:</span> {{ $item->tipo }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Sala:</span> {{ $item->room->name ?? '' }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Data:</span> {{ \Carbon\Carbon::parse($item->date)->isoFormat('dddd, DD \d\e MMMM \d\e Y') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span style="font-weight: 800;">Horário:</span> {{ $item->hour->hour }}
                </div>
            </div>
        </div>
    </div>
@empty
    <p>Nenhum agendamento para este mês</p>
@endforelse
<div class="modal-footer" style="display: none">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-secondary" onclick="$('#modalGlobal').modal('hide'); $('.modal-footer').remove()">Fechar</button>
        </div>
    </div>
</div>
<script>
    $('.modal-footer').insertAfter($('.modal-body')).show();
    $('#modalGlobal').on("hidden.bs.modal", function (e) {
        $('.modal-footer').remove();
    });
</script>
