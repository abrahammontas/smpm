<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
			<h2 class="sub-header">Edit post</h2>
			<?php echo Form::model($post, array('route' => array('post.update', $post->id),'method' => 'put', 'enctype' => 'multipart/form-data')); ?>

			<div class="form-group">
				<?php echo Form::label('Text'); ?>

				<?php echo Form::text('text', null,
                    array('class'=>'form-control',
                          'placeholder'=>'Get your best deals HEREE!!!')); ?>

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
						<option value="<?php echo e($a->id); ?>" <?php if($a->id == $post->account_id): ?> selected <?php endif; ?>><?php echo e($a->alias); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				</select>
			</div>
	        <div class="form-group">
				<?php echo Form::label('Image'); ?>

				<?php if(isset($post->images->first()->image)): ?>
	            <img style="height:100px;" class="img img-responsive" src="/posts/<?php echo e($post->images->first()->image); ?>"/>
	    		<?php endif; ?>
				<div class='input-group date' id='image'>
					<input type='file' name="image" class="form-control" />
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
		var timeSql, date, time;
		timeSql = '<?php echo e($post->post_time); ?>';
		timeSql = timeSql.split(' ');
		date = timeSql[0];
		time = timeSql[1];
		date = date.split('-');
		time = time.split(':');

		postTime = new Date(date[0], date[1], date[2], time[0], time[1], time[2], 0);
		postTime.setMonth(postTime.getMonth() - 1);

		$('#post_time').datetimepicker({
			format: 'YYYY/MM/D hh:mm:ss',
			minDate: moment(),
			date: postTime
		});

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>