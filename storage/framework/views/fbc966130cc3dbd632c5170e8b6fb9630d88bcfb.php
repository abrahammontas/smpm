<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">                
                <?php if(Session::has('success')): ?>
                    <div class="alert alert-success"><?php echo Session::get('success'); ?></div>
                <?php endif; ?>
                <?php if(Session::has('failure')): ?>
                    <div class="alert alert-danger"><?php echo Session::get('failure'); ?></div>
                <?php endif; ?>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>