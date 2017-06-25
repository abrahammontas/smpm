<?php $__env->startSection('content'); ?>

  <div class="col-sm-12 col-md-12 main">
          <a class=" btn btn-warning" href="post/create">Add a new post</a>
          <h2 class="sub-header">Post list</h2>
          <?php if(session('message')): ?>
              <div class="<?php echo e(session('class')); ?>">
                  <?php echo e(session('message')); ?>

              </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Text</th>
                  <th>Post time</th>
                  <th>Account</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr>
                  <td><?php echo e($p->id); ?></td>
                  <td><?php echo e($p->text); ?></td>
                  <td><?php echo e($p->post_time); ?></td>
                  <td><?php echo e($p->account->alias); ?></td>
                  <td>
                      <?php if(isset($p->images->first()->image)): ?>
                          <img style="height:100px;" class="img img-responsive" src="storage/posts/<?php echo e($p->images->first()->image); ?>"/>
                      <?php endif; ?>
                  </td>
                  <td>
                      <?php if($p->published): ?>
                          <span class="label label-success">Published</span>
                      <?php else: ?>
                        <span class="label label-primary">Scheduled</span>
                      <?php endif; ?>
                  </td>
                    <td>
                        <?php echo Form::open(array('method' => 'DELETE', 'route' => array('post.destroy', $p->id))); ?>

                        <div class="btn-group" role="group" aria-label="...">
                            <a href=" <?php if($p->published): ?># <?php else: ?><?php echo e(url('post/'.$p->id.'/edit')); ?><?php endif; ?>"  <?php if($p->published): ?> disabled <?php endif; ?> class='btn btn-primary'> Edit </a>
                              <a href="<?php echo e(url('post/'.$p->id)); ?>" class='btn btn-info'> Show </a>
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