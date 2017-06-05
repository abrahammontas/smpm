<?php $__env->startSection('page_header'); ?>
    <div class="page-title">
        <i class="voyager-data"></i> <?php if(isset($dataType->id)): ?><?php echo e('Edit BREAD for ' . $dataType->name . ' table'); ?><?php elseif(isset($table)): ?><?php echo e('Create BREAD for ' . $table . ' table'); ?><?php endif; ?>
    </div>
    <?php 
        $isModelTranslatable = (!isset($isModelTranslatable) || !isset($dataType)) ? false : $isModelTranslatable;
        if (isset($dataType->name)) {
            $table = $dataType->name;
        }
     ?>
    <?php echo $__env->make('voyager::multilingual.language-selector', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <form action="<?php if(isset($dataType->id)): ?><?php echo e(route('voyager.database.bread.update', $dataType->id)); ?><?php else: ?><?php echo e(route('voyager.database.bread.store')); ?><?php endif; ?>"
                      method="POST" role="form">
                <?php if(isset($dataType->id)): ?>
                    <input type="hidden" value="<?php echo e($dataType->id); ?>" name="id">
                    <?php echo e(method_field("PUT")); ?>

                <?php endif; ?>
                    <!-- CSRF TOKEN -->
                    <?php echo e(csrf_field()); ?>


                    <div class="panel panel-primary panel-bordered">

                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(ucfirst($table)); ?> BREAD info</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="name">Table Name</label>
                                    <input type="text" class="form-control" readonly name="name" placeholder="Name"
                                           value="<?php if(isset($dataType->name)): ?><?php echo e($dataType->name); ?><?php else: ?><?php echo e($table); ?><?php endif; ?>">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="email">Display Name (Singular)</label>
                                    <?php if($isModelTranslatable): ?>
                                        <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                            'isModelTranslatable' => true,
                                            '_field_name'         => 'display_name_singular',
                                            '_field_trans' => get_field_translations($dataType, 'display_name_singular')
                                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                    <input type="text" class="form-control"
                                           name="display_name_singular"
                                           id="display_name_singular"
                                           placeholder="Display Name (Singular)"
                                           value="<?php if(isset($dataType->display_name_singular)): ?><?php echo e($dataType->display_name_singular); ?><?php else: ?><?php echo e($display_name); ?><?php endif; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">Display Name (Plural)</label>
                                    <?php if($isModelTranslatable): ?>
                                        <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                            'isModelTranslatable' => true,
                                            '_field_name'         => 'display_name_plural',
                                            '_field_trans' => get_field_translations($dataType, 'display_name_plural')
                                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                    <input type="text" class="form-control"
                                           name="display_name_plural"
                                           id="display_name_plural"
                                           placeholder="Display Name (Plural)"
                                           value="<?php if(isset($dataType->display_name_plural)): ?><?php echo e($dataType->display_name_plural); ?><?php else: ?><?php echo e($display_name_plural); ?><?php endif; ?>">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="email">URL Slug (must be unique)</label>
                                    <input type="text" class="form-control" name="slug" placeholder="URL slug (ex. posts)"
                                           value="<?php if(isset($dataType->slug)): ?><?php echo e($dataType->slug); ?><?php else: ?><?php echo e($slug); ?><?php endif; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">Icon (optional) Use a <a
                                                href="<?php echo e(voyager_asset('fonts/voyager/icons-reference.html')); ?>"
                                                target="_blank">Voyager Font Class</a></label>
                                    <input type="text" class="form-control" name="icon"
                                           placeholder="Icon to use for this Table"
                                           value="<?php if(isset($dataType->icon)): ?><?php echo e($dataType->icon); ?><?php endif; ?>">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="email">Model Name</label>
                                    <span class="glyphicon glyphicon-question-sign"
                                        aria-hidden="true"
                                        data-toggle="tooltip"
                                        data-placement="right"
                                        title="ex. \App\User, if left empty will try and use the table name"></span>
                                    <input type="text" class="form-control" name="model_name" placeholder="Model Class Name"
                                           value="<?php if(isset($dataType->model_name)): ?><?php echo e($dataType->model_name); ?><?php else: ?><?php echo e($model_name); ?><?php endif; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">Controller Name</label>
                                    <span class="glyphicon glyphicon-question-sign"
                                        aria-hidden="true"
                                        data-toggle="tooltip"
                                        data-placement="right"
                                        title="ex. PageController, if left empty will use the BREAD Controller"></span>
                                    <input type="text" class="form-control" name="controller" placeholder="Controller Name"
                                           value="<?php if(isset($dataType->controller)): ?><?php echo e($dataType->controller); ?><?php endif; ?>">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="generate_permissions">Generate Permissions</label><br>
                                    <?php $checked = (isset($dataType->generate_permissions) && $dataType->generate_permissions == 1) ? true : (isset($generate_permissions) && $generate_permissions) ? true : false; ?>
                                    <input type="checkbox" name="generate_permissions" class="toggleswitch"
                                           <?php if($checked): ?> checked <?php endif; ?>>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="server_side">Server-side Pagination</label><br>
                                    <?php $checked = (isset($dataType->server_side) && $dataType->server_side == 1) ? true : (isset($server_side) && $server_side) ? true : false; ?>
                                    <input type="checkbox" name="server_side" class="toggleswitch"
                                           <?php if($checked): ?> checked <?php endif; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                          placeholder="Description"
                                    ><?php if(isset($dataType->description)): ?><?php echo e($dataType->description); ?><?php endif; ?></textarea>
                            </div>
                        </div><!-- .panel-body -->
                    </div><!-- .panel -->

                    <div class="panel panel-primary panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit the rows for the <?php echo e($table); ?> table below:</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row fake-table-hd">
                                <div class="col-xs-2">Field</div>
                                <div class="col-xs-2">Visibility</div>
                                <div class="col-xs-2">Input Type</div>
                                <div class="col-xs-2">Display Name</div>
                                <div class="col-xs-4">Optional Details</div>
                            </div>

                            <div id="bread-items">
                            <?php 
                                $r_order = 0;
                             ?>
                            <?php $__currentLoopData = $fieldOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php 
                                    $r_order += 1;
                                 ?>

                                <?php if(isset($dataType->id)): ?>
                                    <?php $dataRow = TCG\Voyager\Models\DataRow::where('data_type_id', '=',
                                            $dataType->id)->where('field', '=', $data['field'])->first(); ?>
                                <?php endif; ?>

                                <div class="row row-dd">
                                    <div class="col-xs-2">
                                        <h4><strong><?php echo e($data['field']); ?></strong></h4>
                                        <strong>Type:</strong> <span><?php echo e($data['type']); ?></span><br/>
                                        <strong>Key:</strong> <span><?php echo e($data['key']); ?></span><br/>
                                        <strong>Required:</strong>
                                        <?php if($data['null'] == "NO"): ?>
                                            <span>Yes</span>
                                            <input type="hidden" value="1" name="field_required_<?php echo e($data['field']); ?>"
                                                   checked="checked">
                                        <?php else: ?>
                                            <span>No</span>
                                            <input type="hidden" value="0" name="field_required_<?php echo e($data['field']); ?>">
                                        <?php endif; ?>
                                        <div class="handler glyphicon glyphicon-sort"></div>
                                        <input class="row_order" type="hidden" value="<?php echo e($r_order); ?>" name="field_order_<?php echo e($data['field']); ?>">
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="checkbox"
                                               id="field_browse_<?php echo e($data['field']); ?>"
                                               name="field_browse_<?php echo e($data['field']); ?>"
                                               <?php if(isset($dataRow->browse) && $dataRow->browse): ?>
                                                    <?php echo e('checked="checked"'); ?>

                                               <?php elseif($data['key'] == 'PRI'): ?>
                                               <?php elseif($data['type'] == 'timestamp' && $data['field'] == 'updated_at'): ?>
                                               <?php elseif(!isset($dataRow->browse)): ?>
                                                    <?php echo e('checked="checked"'); ?>

                                               <?php endif; ?>>
                                        <label for="field_browse_<?php echo e($data['field']); ?>">Browse</label><br/>
                                        <input type="checkbox"
                                               id="field_read_<?php echo e($data['field']); ?>"
                                               name="field_read_<?php echo e($data['field']); ?>" <?php if(isset($dataRow->read) && $dataRow->read): ?><?php echo e('checked="checked"'); ?><?php elseif($data['key'] == 'PRI'): ?><?php elseif($data['type'] == 'timestamp' && $data['field'] == 'updated_at'): ?><?php elseif(!isset($dataRow->read)): ?><?php echo e('checked="checked"'); ?><?php endif; ?>>
                                        <label for="field_read_<?php echo e($data['field']); ?>">Read</label><br/>
                                        <input type="checkbox"
                                               id="field_edit_<?php echo e($data['field']); ?>"
                                               name="field_edit_<?php echo e($data['field']); ?>" <?php if(isset($dataRow->edit) && $dataRow->edit): ?><?php echo e('checked="checked"'); ?><?php elseif($data['key'] == 'PRI'): ?><?php elseif($data['type'] == 'timestamp' && $data['field'] == 'updated_at'): ?><?php elseif(!isset($dataRow->edit)): ?><?php echo e('checked="checked"'); ?><?php endif; ?>>
                                        <label for="field_edit_<?php echo e($data['field']); ?>">Edit</label><br/>
                                        <input type="checkbox"
                                               id="field_add_<?php echo e($data['field']); ?>"
                                               name="field_add_<?php echo e($data['field']); ?>" <?php if(isset($dataRow->add) && $dataRow->add): ?><?php echo e('checked="checked"'); ?><?php elseif($data['key'] == 'PRI'): ?><?php elseif($data['type'] == 'timestamp' && $data['field'] == 'created_at'): ?><?php elseif($data['type'] == 'timestamp' && $data['field'] == 'updated_at'): ?><?php elseif(!isset($dataRow->add)): ?><?php echo e('checked="checked"'); ?><?php endif; ?>>
                                            <label for="field_add_<?php echo e($data['field']); ?>">Add</label><br/>
                                        <input type="checkbox"
                                               id="field_delete_<?php echo e($data['field']); ?>"
                                               name="field_delete_<?php echo e($data['field']); ?>" <?php if(isset($dataRow->delete) && $dataRow->delete): ?><?php echo e('checked="checked"'); ?><?php elseif($data['key'] == 'PRI'): ?><?php elseif($data['type'] == 'timestamp' && $data['field'] == 'updated_at'): ?><?php elseif(!isset($dataRow->delete)): ?><?php echo e('checked="checked"'); ?><?php endif; ?>>
                                                <label for="field_delete_<?php echo e($data['field']); ?>">Delete</label><br/>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="hidden" name="field_<?php echo e($data['field']); ?>" value="<?php echo e($data['field']); ?>">
                                        <?php if($data['type'] == 'timestamp'): ?>
                                            <p>Timestamp</p>
                                            <input type="hidden" value="timestamp"
                                                   name="field_input_type_<?php echo e($data['field']); ?>">
                                        <?php else: ?>
                                            <select name="field_input_type_<?php echo e($data['field']); ?>">
                                                <?php $__currentLoopData = Voyager::formFields(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formField): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                    <option value="<?php echo e($formField->getCodename()); ?>" <?php if(isset($dataRow->type) && $dataRow->type == $formField->getCodename()): ?><?php echo e('selected'); ?><?php endif; ?>>
                                                        <?php echo e($formField->getName()); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control"
                                               value="<?php if(isset($dataRow->display_name)): ?><?php echo e($dataRow->display_name); ?><?php else: ?><?php echo e(ucwords(str_replace('_', ' ', $data['field']))); ?><?php endif; ?>"
                                               name="field_display_name_<?php echo e($data['field']); ?>">
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="alert alert-danger validation-error">
                                            Invalid JSON
                                        </div>
                                        <textarea id="json-input-<?php echo e($data['field']); ?>" class="resizable-editor" data-editor="json" name="field_details_<?php echo e($data['field']); ?>"><?php if(isset($dataRow->details)): ?><?php echo e($dataRow->details); ?><?php endif; ?></textarea>
                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!-- .panel-body -->
                    </div><!-- .panel -->

                </form>
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .page-content -->



<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(voyager_asset('lib/js/ace/ace.js')); ?>"></script>
    <?php if($isModelTranslatable): ?>
        <script type="text/javascript" src="<?php echo e(voyager_asset('js/multilingual.js')); ?>"></script>
    <?php endif; ?>
    <script>
        window.invalidEditors = [];
        var validationAlerts = $('.validation-error');
        validationAlerts.hide();
        $(function () {
            <?php if($isModelTranslatable): ?>
                /**
                 * Multilingual setup
                 */
                $('.side-body').multilingual({
                    "form":    'form',
                    "editing": true
                });
            <?php endif; ?>

            /**
             * Reorder items
             */
            $('#bread-items').sortable({
                update: function (e, ui) {
                    var _rows = $('#bread-items').find('.row_order'),
                        _size = _rows.length;

                    for (var i = 0; i < _size; i++) {
                        $(_rows[i]).val(i+1);
                    }
                }
            });

            $('#bread-items').disableSelection();


            $('textarea[data-editor]').each(function () {
                var textarea = $(this),
                mode = textarea.data('editor'),
                editDiv = $('<div>', {
                    position: 'absolute',
                    width: 250,
                    resize: 'vertical',
                    class: textarea.attr('class')
                }).insertBefore(textarea),
                editor = ace.edit(editDiv[0]),
                _session = editor.getSession(),
                valid = false;
                textarea.hide();

                // Validate JSON
                _session.on("changeAnnotation", function(){
                    valid = _session.getAnnotations().length ? false : true;
                    if (!valid) {
                        if (window.invalidEditors.indexOf(textarea.attr('id')) < 0) {
                            window.invalidEditors.push(textarea.attr('id'));
                        }
                    } else {
                        for(var i = window.invalidEditors.length - 1; i >= 0; i--) {
                            if(window.invalidEditors[i] == textarea.attr('id')) {
                               window.invalidEditors.splice(i, 1);
                            }
                        }
                    }
                });

                // Use workers only when needed
                editor.on('focus', function () {
                    _session.setUseWorker(true);
                    $('#bread-items').sortable("disable");
                });
                editor.on('blur', function () {
                    if (valid) {
                        textarea.siblings('.validation-error').hide();
                        _session.setUseWorker(false);
                    } else {
                        textarea.siblings('.validation-error').show();
                    }
                    $('#bread-items').sortable("enable");
                });

                _session.setUseWorker(false);

                editor.setAutoScrollEditorIntoView(true);
                editor.$blockScrolling = Infinity;
                editor.setOption("maxLines", 30);
                editor.setOption("minLines", 4);
                editor.setOption("showLineNumbers", false);
                editor.setTheme("ace/theme/github");
                _session.setMode("ace/mode/json");
                if (textarea.val()) {
                    _session.setValue(JSON.stringify(JSON.parse(textarea.val()), null, 4));
                }

                _session.setMode("ace/mode/" + mode);

                // copy back to textarea on form submit...
                textarea.closest('form').on('submit', function (ev) {
                    if (window.invalidEditors.length) {
                        ev.preventDefault();
                        ev.stopPropagation();
                        validationAlerts.hide();
                        for (var i = window.invalidEditors.length - 1; i >= 0; i--) {
                            $('#'+window.invalidEditors[i]).siblings('.validation-error').show();
                        }
                        toastr.error('Seems like you introduced some invalid JSON.', 'Validation errors', {"preventDuplicates": true, "preventOpenDuplicates": true});
                    } else {
                        if (_session.getValue()) {
                            // uglify JSON object and update textarea for submit purposes
                            textarea.val(JSON.stringify(JSON.parse(_session.getValue())));
                        }
                    }
                });
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('.toggleswitch').bootstrapToggle();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>