<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<form class="frm-save" method="post" action="">
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading">
				      			<h4 class="panel-title">
				          			<?=__('Search')?>
				      			</h4>
				    		</div>
				    			
				      		<div class="panel-body">
								<?php foreach ($sys_object->sys_field_list as $index => $field): ?>
				            		<?php if($field->is_hidden == 0 && $field->is_identification == 1): ?>
				            			<?php $field->loadControl();?>
										<div class="form-group">
					            			<label data-original-title=""><?=$field->field_title;?> <span class="description"><?=$field->field_description?></span></label>
					            			<?=Controls_Libraries_Control::render($field->control, $sys_object, $field, array(), $index +1, Controls_Libraries_Control::CONTROL_TYPE_SEARCH);?>
				            			</div>
				            		<?php endif; ?>
				            	<?php endforeach; ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>