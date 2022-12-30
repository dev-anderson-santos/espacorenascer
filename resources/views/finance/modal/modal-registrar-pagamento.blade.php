<form method="POST">
    @csrf
    <input type="hidden" name="user_id" id="user_id" value="{{ $user_id ?? $cliente->user_id ?? '' }}">
    <input type="hidden" name="month" id="month" value="{{ $month ?? '' }}">
    <input type="hidden" name="yaer" id="year" value="{{ $year ?? '' }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Data do pagamento:</label>
                <input type="date" name="payday" id="payday" class="form-control" value="{{ !empty($cliente) ? \Carbon\Carbon::parse($cliente->payday)->format('Y-m-d') : '' }}">
            </div>
        </div>       
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Valor pago:</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ $cliente->amount ?? '' }}">
            </div>
        </div>       
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Valor a pagar:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="amount">R$ {{ number_format($total_a_pagar, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>       
    </div>
    @if (!empty($cliente) && $cliente->status != null)
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{ !empty($cliente) && $cliente->status == 0 ? 'selected' : '' }}>Pendente</option>
                    <option value="1" {{ !empty($cliente) && $cliente->status == 1 ? 'selected' : '' }}>Pago</option>
                </select>
            </div>
        </div>       
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" id="btn-registrar-pagamento">Confirmar Pagamento</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#btn-registrar-pagamento').on('click', function() {
        var user_id = $('#user_id').val();
        var payday = $('#payday').val();
        var amount = $('#amount').val();
        var status = $('#status').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var _token = $('[name="_token"]').val();

        if (payday == '') {
            bootbox.alert({
                title: 'Informação',
                message: 'Informe a data do pagamento'
            });
            return;
        }
        else if (amount == '') {
            bootbox.alert({
                title: 'Informação',
                message: 'Informe o valor pago'
            });
            return;
        }

        $.ajax({
            method: 'POST',
            url: '/app/admin/finance/registrar-pagamento',
            data: {
                user_id: user_id,
                payday: payday,
                amount: amount,
                status: status,
                month: month,
                year: year,
                _token: _token
            },
            success: function(response) {
                if (response.status == 'success') {
                    bootbox.alert({
                        title: 'Informação',
                        message: response.message,
                        callback: function () {
                            location.reload();
                        }
                    });
                } else {
                    console.log(response.messageError);
                    bootbox.alert({
                        title: 'Informação',
                        message: response.message
                    });
                }
            }
        })

    })
</script>