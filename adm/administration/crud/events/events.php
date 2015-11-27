<?php

class Crud_Events_Events
{
	public static function beforeFormOpen($sys_object, $object_data)
	{
		$object_data->email = 'radi prokletinjo eventsa!';
	}

	public static function orderIndexBeforeSaveEvent($sys_object, $object)
	{
		if($object->isEmpty())
		{
			foreach($sys_object->sys_field_list as $field)
			{
				if($field->field_name == 'order_index')
				{
					$sql = "SELECT MAX(id) + 1
							FROM {$sys_object->table_name}";
						
					$object->{$field->field_name} = Libraries_Db_Factory::getDb()->fetchColumn($sql);
				}
			}
		}
	}
	
	public static function logActionAfterSave($sys_object, $object)
	{
		$content = array();
		foreach($sys_object->sys_field_list as $field)
		{
			if($field->is_identification == 1)
			{
				$content[] = $object->{$field->field_name};
			}
		}
		
		Admin_Libraries_Log::getInstance()->logAction('after_save_' . $sys_object->table_name, json_encode($content));
	}
}