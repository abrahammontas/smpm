<?php $__env->startSection('css'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="col-lg-4">
            <h2 class="sub-header">Add fan pages as account</h2>
            <?php echo Form::open(array('url' => 'account/savepages', 'method' => 'post')); ?>

            <div class="form-group">
                <input type="hidden" value="<?php echo e($accountId); ?>" name="accountId">
                <?php echo Form::label('Fan pages'); ?>

                <select style="width:100% !important;" class="js-example-basic-multiple" multiple="multiple" name="accounts[]">
                    <?php $__currentLoopData = $fanPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($page['id']); ?>"><?php echo e($page['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Add</button>
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

<?php $__env->startSection('scripts'); ?>
        <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>