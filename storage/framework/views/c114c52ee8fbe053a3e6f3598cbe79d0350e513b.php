<?php $__env->startSection('content'); ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-4">
          <h2 class="sub-header">Add a new account</h2>
			<h4>Select one of these social medias.</h4>
			<a href="<?php echo e(url('/auth/twitter')); ?>" class="btn btn-primary"><i class="fa fa-twitter"></i> Twitter</a>
			<a href="<?php echo e(url('/auth/facebook')); ?>" class="btn btn-primary"><i class="fa fa-facebook"></i> Facebook</a>
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