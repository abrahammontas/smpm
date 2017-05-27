<?php $__env->startSection('content'); ?>

  <div class="col-sm-12 col-md-12 main">
          <h2 class="sub-header">Post list</h2>
          <div class='<?php if(isset($class)){echo $class;}?>'>
            <?php if(isset($message)){echo $message;}?>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Text</th>
                  <th>Post time</th>
                  <th>Account</th>
                  <th>Image</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr>
                  <td><?php echo e($p->id); ?></td>
                  <td><?php echo e($p->text); ?></td>
                  <td><?php echo e($p->post_time); ?></td>
                  <td><?php echo e($p->account->name); ?></td>
                  <td></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
              </tbody>
            </table>
          </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>