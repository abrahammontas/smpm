<?php $__env->startSection('content'); ?>

  <div class="col-sm-12 col-md-12 main">
      <a class=" btn btn-warning" href="account/create">Add a new account</a>
          <h2 class="sub-header">Account list</h2>
          <div class='<?php if(isset($class)){echo $class;}?>'>
            <?php if(isset($message)){echo $message;}?>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Alias</th>
                  <th>Provider</th>
                  <th>Created at</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr <?php if($a->error): ?>class="danger"<?php endif; ?>>
                  <td><?php echo e($a->id); ?></td>
                  <td><?php echo e($a->alias); ?></td>
                  <td><?php echo e($a->provider); ?></td>
                  <td><?php echo e($a->created_at); ?></td>
                  <td>
                      <?php echo Form::open(array('method' => 'DELETE', 'route' => array('account.destroy', $a->id))); ?>

                      <div class="btn-group" role="group" aria-label="...">
                          <a href="<?php echo e(url('account/'.$a->id.'/edit')); ?>" class='btn btn-primary'> Edit </a>
                          <?php if($a->provider == 'facebook' && $a->facebook_page == 0): ?>
                            <a href="<?php echo e(url('account/'.$a->id.'/pages')); ?>" class='btn btn-info'> Pages </a>
                          <?php endif; ?>
                          <?php echo Form::submit('Delete', array('class' => 'btn btn-danger')); ?>

                      </div>
                      <?php echo Form::close(); ?>

                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
              </tbody>
            </table>
          </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>