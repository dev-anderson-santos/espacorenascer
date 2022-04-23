<?php if($novoAgendamento || $cancelamento): ?>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Profissional:</span> <?php echo e(!empty($schedules) ? $schedules->user->name : auth()->user()->name); ?>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Sala:</span> <?php echo e($room->name ?? ''); ?>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Data:</span> <?php echo e(\Carbon\Carbon::parse($data)->isoFormat('dddd, DD \d\e MMMM \d\e Y') ?? ''); ?>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;">Horário:</span> <?php echo e($hour->hour ?? ''); ?>

    </div>
</div>
<?php if(!empty($schedules)): ?>
<div class="row">
    <div class="col-md-12 <?php echo e($cancelamento ? 'text-danger' : ''); ?>">
        <span style="font-weight: 800;">Criado em:</span> <?php echo e(\Carbon\Carbon::parse($schedules->created_at)->isoFormat('dddd, DD \d\e MMMM \d\e Y') ?? ''); ?>

    </div>
</div>
<div class="row">
    <div class="col-md-12 <?php echo e($cancelamento ? 'text-danger' : ''); ?>">
        <span style="font-weight: 800;">Criado por:</span> <?php echo e(!empty($schedules) ? $schedules->createdBy->name : ''); ?>

    </div>
</div>
<?php endif; ?>
<form action="" method="post">
    <?php if($cancelamento): ?>
        <input type="hidden" name="action" value="<?php echo e($action); ?>">
    <?php endif; ?>
    <input type="hidden" name="cancelamento" value="<?php echo e($cancelamento ?? ''); ?>">
    <div class="row">
        <div class="col-md-12 <?php echo e($cancelamento ? 'text-danger' : ''); ?>">
            <span style="font-weight: 800;">Tipo de agendamento:</span> <?php echo e($cancelamento ? (!empty($schedules) ? $schedules->tipo : '') : ''); ?>

        </div>
    </div>
    <?php if(!$cancelamento): ?>
        <div class="row">
            <div class="col-md-6">
                <select class="form-control" name="" id="type-schedule">
                    <option value="Avulso">Avulso</option>
                    <option value="Fixo">Fixo</option>
                </select>
            </div>
        </div>        
    <?php endif; ?>
    <?php if($cancelamento): ?>
        <?php echo $__env->make('componentes.alerts', [
            'type' => 'alert-danger',
            'text' => 'O agendamento poderá ser cancelado em até 24 horas de antecedência!'
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-fechar" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="agendar"><?php echo e($cancelamento ? 'Cancelar Agendamanto' : 'Agendar'); ?></button>        
    </div>
</form>

<?php elseif(empty($schedule) && (isset($inUse) && $inUse == true)): ?>
<div class="row">
    <div class="col-md-12">
        <span style="font-weight: 800;" class="text-danger">Este horário não está disponível.</span>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>      
</div>
<?php endif; ?>

<script>
$('#agendar').on('click', function () {
    if ($('[name="action"]').val() != undefined) {
        bootbox.confirm({
            title: 'Cancelar Agendamento',
            message: "Deseja realmente cancelar o agendamento?<br> Esta ação não poderá ser desfeita!",
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
                    $.ajax({
                        url: '/app/schedule/to-destroy-schedule',
                        method: 'POST',
                        data: {
                            schedule_id: 1,
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        beforeSend: function () {
                            $('#agendar').prop('disabled', true);
                            $('#btn-fechar').prop('disabled', true);
                            $('#agendar').html('Cancelando <i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(data) {
                            $('#agendar').html('Cancelado!');
                            console.table(data);
                            location.reload();
                        }
                    });
                }
            }
        });
    } else {
        $.ajax({
            url: '<?php echo e(route('schedule.store')); ?>',
            method: 'POST',
            data: {
                room_id: <?php echo e($room->id); ?>,
                hour_id: <?php echo e($hour->id); ?>,
                user_id: <?php echo e(auth()->user()->id); ?>,
                date: $('#data-agendamento').val(),
                created_by: <?php echo e(auth()->user()->id); ?>,
                tipo: $('#type-schedule').val(),
                _token: '<?php echo e(csrf_token()); ?>'
            },
            beforeSend: function () {
                $('#agendar').prop('disabled', true);
                $('#agendar').html('Agendando <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(data) {
                $('#agendar').html('Agendado!');
                console.table(data);
                location.reload();
            }
        });
    }
});
</script><?php /**PATH C:\wamp64\www\espaco_juntos\resources\views/schedule/modals/modal-schedule.blade.php ENDPATH**/ ?>