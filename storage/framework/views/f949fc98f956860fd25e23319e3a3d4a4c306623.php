<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Agenda</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">
        <div class="alert alert-secondary" style="font-size: 15pt" role="alert">
            <i class="fas fa-info-circle"></i> Para realizar um agendamento, clique em um horário <b>Livre</b>.
        </div>
        <form action="<?php echo e(route('schedule.show-specific-shedule')); ?>" method="post" class="form-group">
            <?php echo csrf_field(); ?>
            <div class="form-row">
                <div class="col-md-4">
                    <label for="">Data:</label>
                    <select class="form-control" name="day" id="data-agendamento" onchange="$(this).parents('form').submit()"">
                        <option value="">-- Selecione --</option>
                        <?php $__currentLoopData = $dataSelect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->format('Y-m-d')); ?>" <?php echo e(!empty($_day) && $_day == $d->format('Y-m-d') ? 'selected' : ''); ?>><?php echo e($d->isoFormat('dddd, DD \d\e MMMM \d\e Y')); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>            
        </form>
        <?php if(!empty($showSpecificShedule)): ?>
            <table class="table table-bordered table-striped table-sm" id="schedule-table" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align: center" scope="col"></th>
                        <th style="text-align: center" scope="col">Sala 101</th>
                        <th style="text-align: center" scope="col">Sala 102</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="text-align: center"><?php echo e(\Carbon\Carbon::parse($hour->hour)->format('H')); ?>h</td>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                 
                                <td style="text-align: center">
                                    <?php if($hour->hour < \Carbon\Carbon::now()->format('H:i:s') && $_day == \Carbon\Carbon::now()->format('Y-m-d')): ?>
                                        Indisponível
                                    <?php else: ?>
                                        <a href="javascript:void(0)" onclick="modalGlobalOpen('<?php echo e(route('schedule.modal-schedule', ['room_id' => $room->id, 'hour_id' => $hour->id, 'user_id' => auth()->user()->id, 'data' => $_day])); ?>', 'Agendamento')">
                                        <?php
                                            $schedule = \App\Models\ScheduleModel::where('hour_id', $hour->id)->get();
                                        ?>
                                        <?php if(count($schedule) > 0 && !empty($schedule[$loop->index])): ?>
                                            <?php if($schedule[$loop->index]->date == $_day && $schedule[$loop->index]->room_id == $room->id): ?>
                                                <?php echo e($schedule[$loop->index]->user->name); ?> 
                                            <?php else: ?>
                                                Livre
                                            <?php endif; ?>
                                        <?php else: ?>
                                            Livre
                                        <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\espaco_juntos\resources\views/schedule/index.blade.php ENDPATH**/ ?>