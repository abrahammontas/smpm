

<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
          <h2 class="sub-header">Add a new post</h2>
          <?php echo Form::open(array('url' => 'post')); ?>

          	<div class="form-group">
			    <?php echo Form::label('Text'); ?>

			    <?php echo Form::text('text', null,
			        array('class'=>'form-control', 
			              'placeholder'=>'Twitter account')); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('Post time'); ?>

				<div class='input-group date' id='post_time'>
					<input type='text' name="post_time" class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
				</div>
			</div>

			<div class="form-group">
				<?php echo Form::label('Account'); ?>

				<select class= "form-control" name="account_id" id="account_id">
					<?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
						<option value="<?php echo e($a->id); ?>"><?php echo e($a->name); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				</select>
			</div>

			<button class="btn btn-primary btn-block" type="submit">Add</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment-with-locales.min.js"></script>
	<script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<script>

		$('#post_time').datetimepicker({
			format: 'YYYY/MM/D hh:mm:ss',
			minDate: moment()
		});

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>