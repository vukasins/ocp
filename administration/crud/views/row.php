<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<ul class="nav nav-tabs">
			        <li class="active"><a data-toggle="tab" href="#general">General</a></li>
			        <?php if($object_data->id > 0): ?>
				        <?php foreach($subforms as $subform): ?>
							<?php
								$subobject = new Crud_Models_Object();
								$subobject->load($subform->id_sys_object_child);
								
								if(!$user->role->canExecuteAction('can_edit_' . $subobject->table_name))
								{
									continue;
								}
							?>
							<li><a data-toggle="tab" href="#<?=$subobject->table_name?>"><?=$subform->title?></a></li>
						<?php endforeach;?>
					<?php endif; ?>
				</ul>
				
			    <div class="tab-content">
			        <div id="general" class="tab-pane fade in active">
			            <form class="frm-save" method="post" action="<?=SITE_ROOT_URI?>/crud/save/<?=$sys_object->id?>/<?=$object_data->id?>">
				            <?php foreach ($sys_object->sys_field_list as $index => $field): ?>
			            		<?php if($field->is_hidden == 0): ?>
			            			<?php if($subform_relation_field != null && $subform_relation_field->id == $field->id): ?>
			            				<input type="hidden" name="<?=$field->field_name?>" value="<?=$subform_relation_value?>" />
			            				<?php continue; ?>
			            			<?php endif; ?>
			            			
			            			<?php $field->loadControl();?>
									<div class="form-group">
				            			<label data-original-title="Test"><?=$field->field_title;?> <span class="description"><?=$field->field_description?></span></label>
				            			<?=Controls_Libraries_Control::render($field->control, $sys_object, $field, $object_data);?>
			            			</div>
			            		<?php else: ?>
			            			<input type="hidden" name="<?=$field->field_name?>" value="<?=$object_data->{$field->field_name}?>" />
			            		<?php endif; ?>
			            	<?php endforeach; ?>
		            	</form>
			        </div>
			        
			        <?php if($object_data->id > 0): ?>
				        <?php foreach($subforms as $subform): ?>
							<?php 
								$subobject = new Crud_Models_Object();
								$subobject->load($subform->id_sys_object_child);
								
								if(!$user->role->canExecuteAction('can_edit_' . $subobject->table_name))
								{
									continue;
								}
							?>
							<div id="<?=$subobject->table_name?>" class="tab-pane fade">
					            <div class="subform" data-subform-relation-id="<?=$subform->id?>" data-subform-relation-value="<?=$object_data->id?>" data-sys-object-id="<?=$subform->id_sys_object_child?>"></div>
					        </div>
						<?php endforeach;?>
					<?php endif; ?>
			    </div>
			</div>
		</div>
	</div>
</div>
