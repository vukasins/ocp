<?php 
    $table_name = $control_properties->table_name;
    $conditional_field_id = isset($control_properties->conditional_field_id) ? $control_properties->conditional_field_id : '';
    
    $sys_object = new Crud_Models_Object();
    
    if(!empty($table_name))
    {
	    $sys_object->load($table_name, 'table_name');
	    $sys_object->loadFieldsForObject();
    }
    else
    {
    	$sys_field = new Crud_Models_Field();
    	$sys_field->load($conditional_field_id);
    	$sys_field->loadControl();
    	
	    $sys_object->load($row->{$sys_field->field_name});
	    $sys_object->loadFieldsForObject();
    }
    
    if($sys_object->isEmpty())
    {
    	$data = array();
    }
    else
    {
    	$data = new Libraries_Db_Mysql_Model($sys_object->table_name);
    	$data = $data->search();
    }
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

<?php if(!empty($conditional_field_id)): ?>
	<?php 
		$sys_field = new Crud_Models_Field();
    	$sys_field->load($conditional_field_id);
	?>
	<script>
		$(document).ready(function() {
			$('#<?=$sys_field->field_name?>').change(function() {
				var sys_object_id = $(this).val();
	
				$.ajax({
					method: "POST",
					url: "<?=SITE_ROOT_URI?>/controls/autocomplete/query/",
					dataType: 'json',
					data: { sys_object_id: sys_object_id, current_sys_object_id: <?=$sys_object->id?>, value: '<?=$value?>' },
					success: function(response)
					{
						$('#<?=$field->field_name?>').html('<option value=""></option>');
						for(i = 0; i < response.length; i++)
						{
							var item = response[i];
							var is_selected = sys_object_id == <?=$sys_object->id?> && item[0] == '<?=$value?>' ? true : false;

							$('#<?=$field->field_name?>').append('<option value="' + item[0] + '" ' + (is_selected == true ? 'selected="selected"' : '') + '>' + item[1] + '</option>');
						}
						
					}
				});
			});
		});
	</script>
<?php endif; ?>