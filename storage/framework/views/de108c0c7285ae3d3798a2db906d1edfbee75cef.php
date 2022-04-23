<?php $__env->startSection('content'); ?>
<div class="container">  
    <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
      <div class="col-md-6 px-0">
        <h1 class="display-4 font-italic">Escolha a sala perfeita para você</h1>
        <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
        <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Ver horários disponíveis</a></p>
      </div>
    </div>
  
    <div class="row mb-2">
      <div class="col-md-6">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-5" style="margin: auto">
                <img src="<?php echo e(asset('images/salas/sala_01.webp')); ?>" class="card-img-top" alt="...">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Sala 101</h5>
                  <p class="card-text">Sala ampla, com 9m². Ótima localização</p>
                  <p class="card-text"><small class="text-muted">Ver horários</small></p>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="col-md-5" style="margin: auto">
                <img src="<?php echo e(asset('images/salas/sala_02.webp')); ?>" class="card-img-top" alt="...">
              </div>
              <div class="col-md-7">
                <div class="card-body">
                  <h5 class="card-title text-success">Sala 102</h5>
                  <p class="card-text">Sala ampla, com 9m². Ótima localização</p>
                  <p class="card-text"><small class="text-muted">Ver horários</small></p>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
</div>
<footer class="blog-footer">
    <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    <p>
      <a href="#">Back to top</a>
    </p>
  </footer>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\espaco_juntos\resources\views/schedule.blade.php ENDPATH**/ ?>