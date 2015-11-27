<?php 
    $table_name = $control_properties->table_name;
    
    $sys_object = new Crud_Models_Object();
    $sys_object->load($table_name, 'table_name');
    $sys_object->loadFieldsForObject();
    
    $text_value = '';
    
    if($value)
    {
	    $row = new Libraries_Db_Mysql_Model($sys_object->table_name);
	    $row->load($value);
	    
	    foreach($sys_object->sys_field_list as $sys_field)
		{
			if($sys_field->is_identification == 1 && array_key_exists($sys_field->field_name, $row->data))
			{
				$text_value .= $row->{$sys_field->field_name} . ', ';
			}
		}
    }
?>

<div class="ui-widget">
	<input type="hidden" id="<?=$field->field_name?>" name="<?=$field->field_name?>" value="<?=$value?>" class="form-control" tabindex="<?=$index?>" />
	<input type="text" id="value_<?=$field->field_name?>" placeholder="<?=trim($text_value, ', ');?>" class="form-control" tabindex="<?=$index?>" />
</div>

<script>
$(document).ready(function() {
	$('#value_<?=$field->field_name?>').autocomplete({
		source: "<?=SITE_ROOT_URI?>/controls/autocompleteforeignkey/query/<?=$table_name?>",
		minLength: 1,
		select: function( event, ui ) {
			var holder_id = $(event.target).attr('id').replace('value_', '');
			var holder = $('#' + holder_id);
			
		    $(holder).val(ui.item.id);
		}
	});
});
</script>