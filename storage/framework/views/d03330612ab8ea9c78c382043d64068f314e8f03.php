<?php $__env->startSection('content'); ?>
<?php
?>
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
        <form action="" method="post" class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Data:</label>
                    <select class="form-control" name="" id="">
                        <option value="">-- Selecione --</option>
                        <option value="1"><?php echo e(\Carbon\Carbon::now()->format('D')); ?>, <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?></option>
                        <option value="2"><?php echo e(\Carbon\Carbon::now()->format('D')); ?>, <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?></option>
                        <option value="3"><?php echo e(\Carbon\Carbon::now()->format('D')); ?>, <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?></option>
                    </select>
                </div>
            </div>            
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sala 1</th>
                    <th scope="col">Sala 2</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $hours = \DB::table('hours')->get();
                    $collection = [
                        'livre', 'ocupado'
                    ];
                ?>
                <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($hour->hour); ?></td>
                        <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                 
                            <td><a href="#"><?php echo e($item); ?></a></td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
        

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\espaco_juntos\resources\views/schedule-logged.blade.php ENDPATH**/ ?>