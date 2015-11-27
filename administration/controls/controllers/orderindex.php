<?php

class Controls_Controllers_Orderindex extends Admin_Libraries_Controllers_Secure
{
	private static $is_js_rendered = false;

	public function reorder()
	{
		$object = new Crud_Models_Object();
		$object->load($_POST['object_id']);

		$field = new Crud_Models_Field();
		$field->load($_POST['field_id']);

		$row = new Libraries_Db_Mysql_Model($object->table_name);
		$row->load($_POST['row_id']);

		$where = array();
		$order = array();

		if(strtolower($_POST['direction']) == 'up')
		{
			$where[] = array('AND', $field->field_name, '>', $row->{$field->field_name});
			$order[] = array($field->field_name, 'ASC');
		}
		else
		{
			$where[] = array('AND', $field->field_name, '<', $row->{$field->field_name});
			$order[] = array($field->field_name, 'DESC');
		}

		$replacement_rows = $row->search($where, $order, 0, 1);
		if(count($replacement_rows))
		{
			$replacement_row = $replacement_rows[0];

			$tmp = $replacement_row->{$field->field_name};
			$replacement_row->{$field->field_name} = $row->{$field->field_name};
			$row->{$field->field_name} = $tmp;
				
			$row->save();
			$replacement_row->save();
		}
	}

	public function reordermanual()
	{
		$object = new Crud_Models_Object();
		$object->load($_POST['object_id']);

		$field = new Crud_Models_Field();
		$field->load($_POST['field_id']);

		$row = new Libraries_Db_Mysql_Model($object->table_name);
		$row->load($_POST['row_id']);

		$where = array();
		$order = array();

		$replacement_row = new Libraries_Db_Mysql_Model($object->table_name);
		$replacement_row->load(intval($_POST['value']), $field->field_name);

		if($replacement_row->isEmpty())
		{
			$sql = "SELECT MIN({$field->field_name}) as min, MAX({$field->field_name}) as max
					FROM {$object->table_name}
					WHERE is_deleted = 0";
			
			$min_max = Libraries_Db_Factory::getDb()->fetchRow($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
			
			if($_POST['value'] < $min_max->min)
			{
				$replacement_row = $replacement_row->load($min_max->min, $field->field_name);
				$_POST['value'] = $min_max->min;
			}
			
			if($_POST['value'] > $min_max->max)
			{
				$replacement_row = $replacement_row->load($min_max->max, $field->field_name);
				$_POST['value'] = $min_max->max;
			}

			/*
			$response = array();
			$response['error'] = 'Can\'t find this object';

			echo json_encode($response);
			return;
			*/
		}
		
		$replacement_row->{$field->field_name} = $row->{$field->field_name};
		$replacement_row->save();

		$row->{$field->field_name} = $_POST['value'];
		$row->save();

		$response = array();
		$response['success'] = 1;

		echo json_encode($response);
		return;
	}

	public static function renderJs()
	{
		if(self::$is_js_rendered == false)
		{
			self::$is_js_rendered = true;
			echo Libraries_View::getInstance()->setModule('controls')->load('/orderindex/js');
		}
	}
}