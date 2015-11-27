<?php

class Controls_Controllers_Autocomplete extends Admin_Libraries_Controllers_Secure
{
	public function query()
	{
		$sys_object_id = intval($_POST['sys_object_id']);

		$sys_object = new Crud_Models_Object();
		$sys_object->load($sys_object_id);
		$sys_object->loadFieldsForObject();
	  
		$data = new Libraries_Db_Mysql_Model($sys_object->table_name);
		$data = $data->search();
		 
		$response = array();
		foreach($data as $row)
		{
			$text_value = '';
			
			
			foreach($sys_object->sys_field_list as $sys_field)
			{
				if($sys_field->is_identification == 1 && array_key_exists($sys_field->field_name, $row->data))
				{
					$text_value .= $row->{$sys_field->field_name} . ', ';
				}
			}

			$item = array($row->id, trim($text_value, ', '));
			
			$response[] = $item;
		}
		 
		echo json_encode($response);
	}
}