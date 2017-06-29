<?php $__env->startSection('css'); ?>
    <!-- MetisMenu CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.0/metisMenu.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/3.3.7+1/css/sb-admin-2.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

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
                <?php $__currentLoopData = $dashboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                        <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-<?php echo e($d['account']->provider); ?> fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div><?php echo e($d['account']->alias); ?></div>
                                            <div><?php echo $d['published']; ?> published of <?php echo $d['total']; ?></div>
                                        </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>