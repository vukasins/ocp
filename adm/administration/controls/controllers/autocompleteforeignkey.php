<?php

class Controls_Controllers_Autocompleteforeignkey extends Admin_Libraries_Controllers_Secure
{
	public function query($table_name)
	{
		//$table_name = $_POST['table_name'];
		$query = $_GET['term'];
		
		$sys_object = new Crud_Models_Object();
		$sys_object->load($table_name, 'table_name');
		$sys_object->loadFieldsForObject();
		
		$searchable_fields = array();
		foreach($sys_object->sys_field_list as $sys_field)
		{
			if($sys_field->is_hidden == 0 && $sys_field->is_identification == 1)
			{
				$searchable_fields[] = $sys_field->field_name;
			}
		}
		
		$data = array();
		$sql = "SELECT id, " . implode(', ', $searchable_fields) . "
		        FROM $table_name 
		        WHERE is_deleted = 0 AND (";
		
		foreach($searchable_fields as $searchable_field)
		{
			$sql .= " {$searchable_field} LIKE ?"; 
			$data[] = "%" . $query . "%";
			
			if(end($searchable_fields) != $searchable_field)
			{
				$sql .= " OR";
			}
			else
			{
				$sql .= ')';
			}
		}
		
		$results = Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_ASSOC);
		$response = array();
		
		foreach($results as $result)
		{
			$id = array_shift($result);
			$response[] = array('id' => $id, 'value' => implode(', ', $result));
		}
		
		echo json_encode($response);
	}
}