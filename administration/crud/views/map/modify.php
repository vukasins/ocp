<form method="post" action="<?=SITE_ROOT_URI?>/crud/objects/modify/<?=$sys_object->id?>">
	<div class="content">
	    <div class="row">
	        <div class="col-xs-12">
	            <div class="box box-primary">
	                <ul class="nav nav-tabs">
	                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
	                    <li class=""><a data-toggle="tab" href="#subforms">Subforms</a></li>
	                    <li class=""><a data-toggle="tab" href="#fields">Fields</a></li>
	                </ul>
	                
	                <div class="tab-content">
	                    <div id="general" class="tab-pane fade in active">
	                        <div class="form-group">
			                    <label>Table name</label>
			                    <input class="form-control" type="text" name="table_title" value="<?=$sys_object->table_title?>" />
			                </div>
			                
			                <div class="form-group">
			                    <label>Group name</label>
			                    <input class="form-control" type="text" name="group_name" value="<?=$sys_object->group_name?>" />
			                </div>
			                
			                <div class="form-group">
			                    <label>Custom CRUD class</label>
			                    <input class="form-control" type="text" name="custom_crud_class" value="<?=$sys_object->custom_crud_class?>" />
			                </div>
			                
			                <div class="form-group">
			                    <input class="" type="checkbox" name="is_system" id="is_system" value="1" <?=($sys_object->is_system == 1 ? 'checked="checked"' : '')?> /> <label for="is_system"> </label>
			                    <label for="is_system">Is system object</label>
			                </div>
	                    </div>
	                    
	                    <div id="subforms" class="tab-pane">
                            <div class="form-group">
			                    <div class="subforms"></div>
			                </div>
                        </div>
                        
                        <div id="fields" class="tab-pane">
							<div class="box">
								<p>
									<a href="#" class="btn btn-primary field-toggler"><i class="fa fa-plus-square-o"></i> Open all fields</a>
								</p>
							</div>
                        	
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						        <?php foreach ($sys_object->sys_field_list as $field): ?>
						            <?php $field->loadControl(); ?>
						            
						            <div class="panel panel-default" data-field-id="<?=$field->id?>">
						                <div class="panel-heading" role="tab" id="heading<?=$field->field_name;?>">
						                    <h4 class="panel-title">
						                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$field->field_name;?>" aria-expanded="true" aria-controls="collapse<?=$field->field_name;?>">
						                            <?=$field->field_title;?>
						                        </a>
						                        <div class="ocp-checkbox">
						                            <input type="checkbox" name="is_hidden[<?=$field->id?>]" id="is_hidden[<?=$field->id?>]" value="1" <?=($field->is_hidden == 1 ? 'checked="checked"' : '')?> /> <label for="is_hidden[<?=$field->id?>]">Hidden</label>
						                        </div>
						                        <div class="ocp-checkbox">
						                            <input type="checkbox" name="is_identification[<?=$field->id?>]" id="is_identification[<?=$field->id?>]" value="1" <?=($field->is_identification == 1 ? 'checked="checked"' : '')?> /> <label for="is_identification[<?=$field->id?>]">Identification</label>
						                        </div>
						                    </h4>
						                </div>
						
						                <input type="hidden" class="order_index" name="order_index[<?=$field->id?>]" value="<?=$field->order_index?>" />
						
						                <div id="collapse<?=$field->field_name;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$field->field_name;?>">
						                    <div class="panel-body">
						                            
						                        <div class="form-group">
						                            <label style="display: block; width: 100%;"><h4 class="subform-title">General</h4></label>
						                            <label>Title</label>
						                            <div class="title">
						                                <input class="form-control" type="text" name="field_title[<?=$field->id?>]" value="<?=$field->field_title?>" />
						                            </div>
						                        </div>
						                        
						                        <div class="form-group">
						                            <label>Description</label>
						                            <div class="description">
						                                <input class="form-control" type="text" name="field_description[<?=$field->id?>]" value="<?=$field->field_description?>" />
						                            </div>
						                        </div>
						                        
						                        <div class="form-group">
						                            <label><h4 class="subform-title">Control properties</h4></label>
						                        </div>
						                    
						                        <div class="form-group">
						                            <label>Form control</label>
													<div class="ocp-select">
														<select class="form-control control-selector" name="id_sys_control[<?=$field->id?>]" data-field-id="<?=$field->id?>">
															<?php foreach($controls as $control): ?>
																<option value="<?=$control->id?>" <?=($field->id_sys_control == $control->id ? 'selected="selected"' : '')?>><?=$control->title?></option>
															<?php endforeach; ?>
														</select>
													</div>
						                        </div>
						                        
						                        <div class="form-group" style="display: none">
						                            <div class="control-properties"></div>
						                        </div>
						
						                        <div class="form-group">
						                            <label><h4 class="subform-title">Validators</h4></label>
						                            <div class="validators-selector">
						                                <select class="form-control control-validators" name="ids_sys_validator[<?=$field->id?>][]" data-field-id="<?=$field->id?>" multiple="multiple">
						                                    <option value="">--Validators--</option>
						                                    <?php foreach($validators as $validator): ?>
						                                        <option value="<?=$validator->id?>" <?=(in_array($validator->id, explode(',', $field->ids_sys_validator)) ? 'selected="selected"' : '')?>><?=$validator->title?></option>
						                                    <?php endforeach; ?>
						                                </select>
						                            </div>
						                        </div>

											</div>
						                </div>
						            </div>
						        <?php endforeach; ?>
						    </div>
                        </div>
	                    
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</form>

<script>
    $(document).ready(function() {
        $("#accordion").sortable({
            //placeholder: 'ui-state-highlight',
            stop: function( event, ui ) {
                $("#accordion > .panel").each(function(index, item) {
                    var reverse_index = $("#accordion > .panel").length - index;
                    $(item).find('.order_index').val(reverse_index);
                });
            }
        });
        
        $('.control-selector').change(function(event) {
            var control = $(this);

            $(control).parents('.panel-body').find('.control-properties').html('');
            $(control).parents('.panel-body').find('.control-properties').parent('.form-group').hide();
            
            $.ajax({
                type: "POST",
                url: '<?=SITE_ROOT_URI?>/controls/getModifyForm/',
                data: {field_id: $(control).data('field-id'), control_id: $(this).val()},
                success: function(response)
                {
                    if(response != '')
                    {
                        $(control).parents('.panel-body').find('.control-properties').html(response);
                        $(control).parents('.panel-body').find('.control-properties').parent('.form-group').show();
                    }
                }
            });
        });

        var loadSubforms = function()
        {
            $.ajax({
                type: "POST",
                url: '<?=SITE_ROOT_URI?>/crud/objects/loadsubforms/<?=$sys_object->id?>',
                data: {},
                success: function(response)
                {
                    $('.subforms').html(response);
                }
            });
        };

        $('.control-selector').trigger('change');
        
        $('.field-toggler').click(function(event) {
            event.preventDefault();

            if($(this).parents('.tab-pane').find('.panel-collapse.collapse.in').length == $(this).parents('.tab-pane').find('.panel-collapse.collapse').length)
            {
            	$(this).parents('.tab-pane').find('.panel-collapse.collapse').removeClass('in');
            	$(this).html('<i class="fa fa-plus-square-o"></i> Open all fields');
            }
            else
            {
            	$(this).parents('.tab-pane').find('.panel-collapse.collapse').addClass('in');
            	$(this).html('<i class="fa fa-minus-square-o"></i> Close all fields');
            }
            
            return false;
        });

        loadSubforms();
        
    });
</script>