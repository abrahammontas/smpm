

<?php $__env->startSection('content'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h2 class="sub-header">Edit account (<?php echo e($account->name); ?>)</h2>
		<div class="col-lg-4">
          <?php echo Form::model($account, array('route' => array('account.update', $account->id),'method' => 'put')); ?>

			<div class="form-group">
				<?php echo Form::label('Name'); ?>

				<?php echo Form::text('name', null,
                    array('class'=>'form-control',
                          'placeholder'=>'Twitter account')); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('User'); ?>

				<?php echo Form::text('identifier', null,
                    array('class'=>'form-control',
                          'placeholder'=>'Twitter account')); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('Password'); ?>

				<?php echo Form::text('password', null,
                    array('class'=>'form-control',
                          'placeholder'=>'Twitter account')); ?>

			</div>
			<button class="btn btn-primary btn-block" type="submit">Edit</button>
		  <?php echo Form::close(); ?>

		</div>	
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
		    <?php if(count($errors) > 0): ?>
				<div class="alert alert-danger">
						<ul>
			    		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				     	   <li><?php echo e($error); ?></li>
			    		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			    	</ul>
			    </div>
			<?php endif; ?>
		</div>	

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>