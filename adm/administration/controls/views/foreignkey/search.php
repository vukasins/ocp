<?php 
    $table_name = $control_properties->table_name;
    
    $sys_object = new Crud_Models_Object();
    $sys_object->load($table_name, 'table_name');
    $sys_object->loadFieldsForObject();
    
    $data = new Libraries_Db_Mysql_Model($sys_object->table_name);
    $data = $data->search();
?>
<div class="ocp-select">
	<select id="<?=$field->field_name?>" name="<?=$field->field_name?>" class="form-control" tabindex="<?=$index?>">
		<option value=""></option>
		
		<?php if(!empty($data)): ?>
			<?php foreach($data as $row): ?>
				<option value="<?=$row->id?>" <?=(isset($_POST[$field->field_name]) && $row->id == $_POST[$field->field_name] ? 'selected="selected"' : '')?>>
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

<input type="hidden" name="search_field_query_<?=$field->field_name?>" value="(<?=$field->field_name?> = :<?=$field->field_name?>)" />