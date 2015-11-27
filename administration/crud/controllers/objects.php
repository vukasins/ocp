<?php

class Crud_Controllers_Objects extends Admin_Libraries_Controllers_Secure
{
	public function maplist()
	{
		$db_object_list = Libraries_Db_Factory::getDb()->fetchAll("SHOW TABLES", array(), Libraries_Db_Adapter::FETCH_TYPE_NUM);
		$available_db_objects = array();

		foreach($db_object_list as $db_object)
		{
			$available_db_objects[] = $db_object[0];
		}

		Libraries_View::getInstance()->available_db_objects = $available_db_objects;

		$content = Libraries_View::getInstance()->setModule('crud')->load('map/list');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}

	public function map($object_name)
	{
		$sql = "SHOW COLUMNS FROM `{$object_name}`";

		$fields = Libraries_Db_Factory::getDb()->fetchAll($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
		$raw_field_names = array();

		$has_id_field = false;
		$has_is_deleted_field = false;
		$has_last_modify_field = false;

		foreach($fields as $field)
		{
			if($field->Field == 'id')
			{
				$has_id_field = true;
			}

			if($field->Field == 'is_deleted')
			{
				$has_is_deleted_field = true;
			}
				
			if($field->Field == 'last_modify')
			{
				$has_last_modify_field = true;
			}

			$raw_field_names[] = $field->Field;
		}

		if(!$has_id_field)
		{
			$sql = "ALTER TABLE `{$object_name}` ADD COLUMN `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
			Libraries_Db_Factory::getDb()->execute($sql);

			$raw_field_names[] = 'id';

			// reinit fields
			$sql = "SHOW COLUMNS FROM `{$object_name}`";
			$fields = Libraries_Db_Factory::getDb()->fetchAll($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
		}

		if(!$has_is_deleted_field)
		{
			$sql = "ALTER TABLE `{$object_name}` ADD COLUMN `is_deleted` tinyint(1) NOT NULL default 0";
			Libraries_Db_Factory::getDb()->execute($sql);

			$raw_field_names[] = 'is_deleted';
				
			// reinit fields
			$sql = "SHOW COLUMNS FROM `{$object_name}`";
			$fields = Libraries_Db_Factory::getDb()->fetchAll($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
		}

		if(!$has_last_modify_field)
		{
			$sql = "ALTER TABLE `{$object_name}` ADD COLUMN `last_modify` timestamp NULL ON UPDATE CURRENT_TIMESTAMP";
			Libraries_Db_Factory::getDb()->execute($sql);

			$raw_field_names[] = 'last_modify';

			// reinit fields
			$sql = "SHOW COLUMNS FROM `{$object_name}`";
			$fields = Libraries_Db_Factory::getDb()->fetchAll($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
		}

		$mapped_object = new Crud_Models_Object();
		$mapped_object->load($object_name, 'table_name');
		$mapped_object->loadFieldsForObject();

		$is_remap = false;

		if($mapped_object->isEmpty())
		{
			$mapped_object->table_name = $object_name;
			$mapped_object->table_title = $object_name;
			$mapped_object->group_name = __('Just added');
			$mapped_object->save();
		}
		else
		{
			foreach($mapped_object->sys_field_list as $mapped_field)
			{
				if(!in_array($mapped_field->field_name, $raw_field_names))
				{
					$mapped_field->delete();
				}
			}
				
			$is_remap = true;
		}

		foreach($fields as $i => $field)
		{
			$where = array();
			$where[] = array('AND', 'id_sys_object', '=', $mapped_object->id);
			$where[] = array('AND', 'field_name', '=', $field->Field);

			$field_object = new Crud_Models_Field();
			$field_objects = $field_object->search($where);

			if(!empty($field_objects))
			{
				continue;
			}

			$default_control = new Controls_Models_Control();
			$default_control->load(1, 'is_default');

			$field_object->id_sys_object = $mapped_object->id;
			$field_object->id_sys_control = $default_control->id;
			$field_object->field_name = $field->Field;
			$field_object->field_title = $field->Field;

			$field_object->is_hidden = (($field->Field == 'is_deleted' || $field->Field == 'id') ? 1 : 0);
			$field_object->is_identification = ($field->Field == 'is_deleted' || $i >= 4 || $is_remap == true ? 0 : 1);
			$field_object->is_primary_key = (strstr($field->Key, 'PRI') !== false ? 1 : 0);

			$field_object->save();
		}
	}

	public function modifyForm($sys_object_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		// load controls
		$where = array();
		$order = array();

		$order[] = array('title', 'ASC');

		$control = new Controls_Models_Control();
		$controls = $control->search($where, $order);

		// load validators
		$where = array();
		$order = array();

		$order[] = array('title', 'ASC');

		$validator = new Validators_Models_Validator();
		$validators = $validator->search($where, $order);

		Libraries_View::getInstance()->sys_object = $sys_object;
		Libraries_View::getInstance()->controls = $controls;
		Libraries_View::getInstance()->validators = $validators;

		$content = Libraries_View::getInstance()->setModule('crud')->load('map/modify');

		echo $content;
	}

	public function modify($sys_object_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		if(isset($_POST) && !empty($_POST))
		{
			$field_list = array();

			$sys_object->table_title = $_POST['table_title'];
			$sys_object->group_name = $_POST['group_name'];
			$sys_object->custom_crud_class = $_POST['custom_crud_class'];
			$sys_object->is_system = isset($_POST['is_system']) && $_POST['is_system'] == 1 ? 1 : 0;
			$sys_object->save();

			foreach ($_POST['field_title'] as $field_id => $field_title)
			{
				$properties = array();
				foreach($_POST as $key => $value)
				{
					if(preg_match('/^control-properties-/', $key) && isset($value[$field_id]))
					{
						$property_key = str_replace('control-properties-', '', $key);
						$properties[$property_key] = $value[$field_id];
					}
				}

				$field = new Crud_Models_Field();
				$field->load($field_id);

				if($field->isEmpty())
				{
					$field->id_sys_object = $sys_object->id;
				}

				$field->id_sys_control = isset($_POST['id_sys_control'][$field_id]) ? intval($_POST['id_sys_control'][$field_id]) : 0;
				$field->ids_sys_validator = isset($_POST['ids_sys_validator'][$field_id]) ? implode(',', $_POST['ids_sys_validator'][$field_id]) : '';
				$field->field_title = $field_title;
				$field->field_description = $_POST['field_description'][$field_id];
				$field->order_index = $_POST['order_index'][$field_id];

				$field->is_hidden = isset($_POST['is_hidden'][$field_id]) ? intval($_POST['is_hidden'][$field_id]) : 0;
				$field->is_identification = isset($_POST['is_identification'][$field_id]) ? intval($_POST['is_identification'][$field_id]) : 0;

				$field->sys_control_properties = !empty($properties) ? json_encode($properties) : '';

				$field->save();
			}

			foreach($_POST['id_sys_object_child'] as $relation_id => $id_sys_object_child)
			{
				$subform = new Crud_Models_Subform();
				$subform->load($relation_id);

				if(!$subform->isEmpty())
				{
					if($subform->id_sys_object_parent != $sys_object->id)
					{
						$subform = new Crud_Models_Subform();
					}
				}

				if(isset($_POST['delete']) && isset($_POST['delete'][$relation_id]) && $_POST['delete'][$relation_id] == 1)
				{
					$subform->delete();
				}
				else
				{
					$where = array();
					$where[] = array('AND', 'id_sys_object', '=', $id_sys_object_child);
					$where[] = array('AND', 'field_name', '=', $_POST['sys_field_title'][$relation_id]);

					$field = new Crud_Models_Field();
					$fields = $field->search($where);

					if(empty($fields))
					{
						continue;
					}

					$field = $fields[0];

					$subform->id_sys_object_parent = $sys_object->id;
					$subform->id_sys_object_child = $id_sys_object_child;
					$subform->id_sys_field = $field->id;
					$subform->title = $_POST['title'][$relation_id];
					$subform->save();
				}
			}
		}

		header('location: ' . SITE_ROOT_URI . '/crud/objects/maplist/');
		exit;
	}

	public function delete()
	{
		$object_id = intval($_POST['object_id']);

		$object = new Crud_Models_Object();
		$object->load($object_id);
		$object->loadFieldsForObject();

		foreach($object->sys_field_list as $field)
		{
			$field->delete();
		}

		$object->delete();
	}

	public function loadsubforms($parent_sys_object_id)
	{
		// load relations
		$where = array();
		$order = array();

		$where[] = array('AND', 'id_sys_object_parent', '=', $parent_sys_object_id);
		$order[] = array('table_name', 'ASC');

		$selected_maped_object = new Crud_Models_Subform();
		$selected_maped_objects = $selected_maped_object->search($where);

		// load maped objects
		$where = array();
		$order = array();

		$where[] = array('AND', 'id', '!=', $parent_sys_object_id);
		$order[] = array('table_name', 'ASC');

		$maped_object = new Crud_Models_Object();
		$maped_objects = $maped_object->search($where, $order);

		Libraries_View::getInstance()->selected_maped_objects = $selected_maped_objects;
		Libraries_View::getInstance()->maped_objects = $maped_objects;

		echo Libraries_View::getInstance()->setModule('crud')->load('map/subforms');
	}

	public function getfields()
	{
		$object = new Crud_Models_Object();
		$object->load(intval($_POST['sys_object_id']));
		$object->loadFieldsForObject();

		$response = array();
		foreach($object->sys_field_list as $field)
		{
			if($field->is_hidden == 1)
			{
				continue;
			}
				
			$response[] = $field->data;
		}

		echo json_encode($response);
	}
}