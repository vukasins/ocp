<?php 
    $table_name = $control_properties->table_name;
    $conditional_field_id = $control_properties->conditional_field_id;
    
    if(!empty($table_name))
    {
	    $sys_object = new Crud_Models_Object();
	    $sys_object->load($table_name, 'table_name');
	    $sys_object->loadFieldsForObject();
    }
    else
    {
    	$sys_field = new Crud_Models_Field();
    	$sys_field->load($conditional_field_id);
    	$sys_field->loadControl();
    	
    	$sys_object = new Crud_Models_Object();
	    $sys_object->load($row->{$sys_field->field_name});
	    $sys_object->loadFieldsForObject();
    }
    
    $data = new Libraries_Db_Mysql_Model($sys_object->table_name);
    $data = $data->search();
?>
<div class="ocp-select">
	<select id="<?=$field->field_name?>" name="<?=$field->field_name?>" class="form-control" tabindex="<?=$index?>">
		<option value=""></option>
		
		<?php if(!empty($data)): ?>
			<?php foreach($data as $row): ?>
				<option value="<?=$row->id?>" <?=($row->id == $value ? 'selected="selected"' : '')?>>
					<?php 
						$text_value = '';
						foreach($sys_object->sys_field_list as $sys_field)
						{
							if($sys_field->is_identification == 1 && array_key_exists($sys_field->field_name, $row->data))
							{
								$text_value .= $row->{$sys_field->field_name} . ', ';
							}
						}
						
						echo trim($text_value, ', ');
					?>
				</option>
			<?php endforeach; ?>
		<?php endif; ?>
	</select>
</div>