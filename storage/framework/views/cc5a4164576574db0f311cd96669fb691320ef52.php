<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
          <h2 class="sub-header">Edit your profile</h2>
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success"><?php echo Session::get('success'); ?></div>
            <?php endif; ?>
          <?php echo Form::open(array('url' => 'edit-profile', 'enctype' => 'multipart/form-data')); ?>

          	<div class="form-group">
			    <?php echo Form::label('Name'); ?>

			    <?php echo Form::text('name', $user->name,
			        array('class'=>'form-control')); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('Avatar'); ?>

				<?php if(isset($user->avatar)): ?>
				<?php echo e($user->avatar); ?>

	            	<img style="height:100px;" class="img img-responsive" src="/<?php echo e($user->avatar); ?>"/>
	    		<?php endif; ?>
				<div class='input-group date' id='avatar'>
					<input type='file' name="avatar" class="form-control" />
				</div>
			</div>

			<button class="btn btn-primary btn-block" type="submit">Edit</button>
		  <?php echo Form::close(); ?>

			<br>
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

<?php $__env->startSection('scripts'); ?>
        <!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.0/moment-with-locales.min.js"></script>
	<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script>

		$('#post_time').datetimepicker({
			format: 'YYYY/MM/D hh:mm:ss',
			minDate: moment()
		});

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>