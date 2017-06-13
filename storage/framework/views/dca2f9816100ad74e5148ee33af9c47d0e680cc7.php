<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Show post</h2>
		<div class="col-lg-4">
          	<div class="form-group">
			    <?php echo Form::label('Text:'); ?>

			    <?php echo e($post->text); ?>

			</div>
          	<div class="form-group">
			    <?php echo Form::label('Account:'); ?>

			    <?php echo e($post->account->alias); ?>

			</div>
          	<div class="form-group">
			    <?php echo Form::label('Post Time:'); ?>

			    <?php echo e($post->post_time); ?>

			</div>
          	<div class="form-group">
			    <?php echo Form::label('Status:'); ?>

			    <?php if($post->published): ?>
			        <span class="label label-success">Published</span>
			    <?php else: ?>
			    	<span class="label label-primary">Scheduled</span>
			    <?php endif; ?>
			</div>
          	<div class="form-group">
			    <?php echo Form::label('Created at:'); ?>

			    <?php echo e($post->created_at); ?>

			</div>
          	<div class="form-group">
			    <?php echo Form::label('Updated at:'); ?>

			    <?php echo e($post->updated_at); ?>

			</div>
		</div>	
		<div class="col-lg-4">
              <?php $__currentLoopData = $post->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                  <img style="height:100px;" class="img img-responsive" src="/posts/<?php echo e($image->image); ?>"/>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </div>	
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>