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

echo trim($text_value, ', ');