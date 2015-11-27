<?php

class Crud_Controllers_Crud extends Admin_Libraries_Controllers_Secure
{
	public function index()
	{
		$where = array();

		$order = array();
		$order[] = array('group_name', 'ASC');
		$order[] = array('order_index', 'DESC');

		$sys_object = new Crud_Models_Object();
		$sys_object_list = $sys_object->search($where, $order);

		foreach($sys_object_list as $sys_object)
		{
			$sys_object->loadFieldsForObject();
		}
		
		$user = Admin_Libraries_Admin::getLogedUser()->loadRole();

		Libraries_View::getInstance()->sys_object_list = $sys_object_list;
		Libraries_View::getInstance()->user = user;

		$content = Libraries_View::getInstance()->setModule('crud')->load('objects');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}

	public function content($sys_object_id, $current_page = 1, $is_ajax_call = 0, $subform_relation_id = null, $subform_relation_value = null)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		if($sys_object->is_system == 1 && $this->user->role->safe_title != 'administrator')
		{
			if($is_ajax_call)
			{
				return false;
			}
				
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			exit;
		}

		if(!$this->user->role->canExecuteAction('can_view_' . $sys_object->table_name))
		{
			if($is_ajax_call)
			{
				return false;
			}
				
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			exit;
		}

		Libraries_Event::trigger('beforeCrudList', $sys_object);

		if($sys_object->custom_crud_class != '' && (new $sys_object->custom_crud_class instanceof Crud_Interfaces_Crud))
		{
			echo call_user_func(array(new $sys_object->custom_crud_class, 'content'), $sys_object_id);
			return;
		}

		$where = array();
		$order = array();

		$subform_relation_field = null;

		if($subform_relation_id)
		{
			$subform_relation = new Crud_Models_Subform();
			$subform_relation->load($subform_relation_id);

			$subform_relation_field = new Crud_Models_Field();
			$subform_relation_field->load($subform_relation->id_sys_field);

			$where[] = array('AND', $subform_relation_field->field_name, '=', $subform_relation_value);
		}

		if(!isset($_GET['ord_field']))
		{
			foreach($sys_object->sys_field_list as $sys_field)
			{
				if($sys_field->field_name == 'order_index')
				{
					$order[] = array($sys_field->field_name, 'DESC');
					break;
				}
			}
				
			if(empty($order))
			{
				$order[] = array('id', 'DESC');
			}
		}
		else
		{
			$order[] = array($_GET['ord_field'], isset($_GET['ord_direction']) && $_GET['ord_direction'] == 'asc' ? 'asc' : 'desc');
		}

		$sql = "SELECT *
				FROM {$sys_object->table_name}
				WHERE	is_deleted = " . (isset($_SESSION['trash']) && $_SESSION['trash'] == 1 ? 1 : 0);
			
		$sql_count = "	SELECT COUNT(id)
						FROM {$sys_object->table_name}
						WHERE	is_deleted = " . (isset($_SESSION['trash']) && $_SESSION['trash'] == 1 ? 1 : 0);
		$data = array();

		$search_data = array();

		if(isset($_POST) && !empty($_POST))
		{
			foreach($_POST as $key => $value)
			{
				if(preg_match('/^search_field_query_/', $key))
				{
					$field_key = str_replace('search_field_query_', '', $key);
					$matches = array();

					preg_match_all('/\:\w{1,}/', $value, $matches);
						
					if(isset($matches[0]))
					{
						foreach($matches[0] as $i => $match)
						{
							$match = trim($match, ':');

							if(!isset($_POST[$match]))
							{
								continue;
							}
								
							if(empty($_POST[$match]))
							{
								continue;
							}

							// u prvom prolazu dodajemo parametre za upit
							if($i == 0)
							{
								$sql .= ' AND ' . $value;
								$sql_count .= ' AND ' . $value;
							}
							
							$search_data[$match] = $_POST[$match];

							if(preg_match('/LIKE \:(.*?)/', $value))
							{
								$data[$match] = '%' . $_POST[$match] . '%';
							}
							else
							{
								$data[$match] = $_POST[$match];
							}
						}
					}
				}
			}

			/*
			 echo '<pre>'; print_r($sql); echo '</pre>';
			 echo '<pre>'; print_r($data); echo '</pre>'; exit;
			*/
		}
		else
		{
			if(!empty($where))
			{
				foreach($where as $where_item)
				{
					$sql .= ' ' .$where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' ?';
					$sql_count .= ' ' . $where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' ?';

					$data[] = $where_item[3];
				}
			}
		}
			
		if(!empty($order))
		{
			$sql .= ' ORDER BY ';
		}

		foreach($order as $order_item)
		{
			$sql .= $order_item[0] . ' ' . $order_item[1];
		}
			
		$sql .= ' LIMIT ' . ($current_page - 1) * Config_Environment::DEFAULT_ITEMS_PER_PAGE . ', ' . Config_Environment::DEFAULT_ITEMS_PER_PAGE;
			
		$response = Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_ASSOC);
		$generic_model_data_count = Libraries_Db_Factory::getDb()->fetchColumn($sql_count, $data);
			
		$generic_model_data = array();
		foreach($response as $row)
		{
			$generic_model_data[] =  new Libraries_Db_Mysql_Model($sys_object->table_name, $row);
		}
		
		$user = Admin_Libraries_Admin::getLogedUser()->loadRole();

		Libraries_View::getInstance()->search_data = $search_data;
		Libraries_View::getInstance()->sys_object = $sys_object;
		Libraries_View::getInstance()->generic_model_data = $generic_model_data;
		Libraries_View::getInstance()->generic_model_data_count = $generic_model_data_count;
		Libraries_View::getInstance()->current_page = $current_page;
		Libraries_View::getInstance()->is_ajax_call = $is_ajax_call;
		Libraries_View::getInstance()->subform_relation_field = $subform_relation_field;
		Libraries_View::getInstance()->user = $user;

		$page_count = ceil($generic_model_data_count / Config_Environment::DEFAULT_ITEMS_PER_PAGE);

		if($page_count > 0 && $current_page > $page_count)
		{
			header('location: ' . SITE_ROOT_URI . '/crud/content/' . $sys_object_id . '/' . $page_count);
			exit;
		}

		$content = Libraries_View::getInstance()->setModule('crud')->load('rows');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		if(!$is_ajax_call)
		{
			Libraries_Layout::getInstance()->render();
		}
		else
		{
			echo $content;
		}
	}

	public function modify($sys_object_id, $row_id = '', $subform_relation_id = null, $subform_relation_value = null)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		if($sys_object->is_system == 1 && $this->user->role->safe_title != 'administrator')
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			//header('location: ' . SITE_ROOT_URI . '/admin/error/');
			exit;
		}

		if(!$this->user->role->canExecuteAction('can_view_' . $sys_object->table_name))
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			//header('location: ' . SITE_ROOT_URI . '/admin/error/');
			exit;
		}

		if($sys_object->custom_crud_class != '' && (new $sys_object->custom_crud_class instanceof Crud_Interfaces_Crud))
		{
			echo call_user_func(array(new $sys_object->custom_crud_class, 'modify'), $sys_object_id, $row_id);
		}
		else
		{
			$object_data = new Libraries_Db_Mysql_Model($sys_object->table_name);
			$subforms = array();

			if($row_id != '')
			{
				$object_data->load(intval($row_id));

				$where = array();
				$where[] = array('AND', 'id_sys_object_parent', '=', $sys_object->id);

				$subform = new Crud_Models_Subform();
				$subforms = $subform->search($where);
			}
				
			if(isset($_GET['clone']) && $_GET['clone'] == 1)
			{
				$object_data->id = null;
			}

			$subform_relation = null;
			$subform_relation_field = null;

			if($subform_relation_id)
			{
				$subform_relation = new Crud_Models_Subform();
				$subform_relation->load($subform_relation_id);
					
				$subform_relation_field = new Crud_Models_Field();
				$subform_relation_field->load($subform_relation->id_sys_field);

			}

			Libraries_Event::trigger('beforeFormOpen', $sys_object, $object_data);
			
			$user = Admin_Libraries_Admin::getLogedUser()->loadRole();

			Libraries_View::getInstance()->sys_object = $sys_object;
			Libraries_View::getInstance()->object_data = $object_data;
			Libraries_View::getInstance()->subforms = $subforms;
			Libraries_View::getInstance()->subform_relation = $subform_relation;
			Libraries_View::getInstance()->subform_relation_field = $subform_relation_field;
			Libraries_View::getInstance()->subform_relation_value = $subform_relation_value;
			Libraries_View::getInstance()->user = $user;

			$content = Libraries_View::getInstance()->setModule('crud')->load('row');

			echo $content;
		}
	}

	/*
	 public function copypaste($sys_object_id, $row_id)
	 {
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		$object_data = new Libraries_Db_Mysql_Model($sys_object->table_name);
		$object_data->load(intval($row_id));

		unset($object_data->data['id']);
		$object_data->save();
		}
		*/

	public function delete($sys_object_id, $row_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));

		if($sys_object->is_system == 1 && $this->user->role->safe_title != 'administrator')
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			return false;
		}

		if(!$this->user->role->canExecuteAction('can_delete_' . $sys_object->table_name))
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			exit;
		}

		$object = new Libraries_Db_Mysql_Model($sys_object->table_name);
		$object->load(intval($row_id));

		Libraries_Event::trigger('beforeCrudDelete', $sys_object, $object);

		$object->delete();

		Libraries_Event::trigger('afterCrudDelete', $sys_object, $object);
	}

	public function save($sys_object_id, $row_id = '')
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		if($sys_object->is_system == 1 && $this->user->role->safe_title != 'administrator')
		{
			$response = array();
			$response['errors'] = array('Can\'t edit this object');

			echo json_encode($response);
			return;
		}

		if(!$this->user->role->canExecuteAction('can_edit_' . $sys_object->table_name))
		{
			$response = array();
			$response['errors'] = array('Can\'t edit this object');

			echo json_encode($response);
			return;
		}

		if($sys_object->custom_crud_class != '' && (new $sys_object->custom_crud_class instanceof Crud_Interfaces_Crud))
		{
			echo call_user_func(array(new $sys_object->custom_crud_class, 'save'), $sys_object_id, $row_id);
		}
		else
		{
			$object = new Libraries_Db_Mysql_Model($sys_object->table_name);

			if(!empty($row_id))
			{
				$object->load(intval($row_id));

				if(isset($_POST['last_modify']) && $_POST['last_modify'] != $object->last_modify)
				{
					$response = array();
					$response['errors']['general'] = array('Object is already saved by another user!');

					echo json_encode($response);
					return;
				}
			}

			$response = array();
			$response['errors'] = array();
			$response['message'] = '';

			foreach($sys_object->sys_field_list as $field)
			{
				if($field->is_hidden == 1)
				{
					continue;
				}

				$field->loadValidators();

				$field_value = isset($_POST[$field->field_name]) ? $_POST[$field->field_name] : null;

				if(!empty($field->validators))
				{
					foreach($field->validators as $validator)
					{
						$validator_response = call_user_func(array($validator->class, 'validate'), $field_value);

						if(!$validator_response)
						{
							$response['errors'][] = array('field' => $field->field_name, 'message' => call_user_func(array($validator->class, 'getFalseMessage')));
							continue 2; // goto next field
						}
					}
				}

				$object->{$field->field_name} = $field_value;
			}

			unset($object->data['last_modify']);
				
			/*
			 echo '<pre>'; print_r($_POST); echo '</pre>';
			 echo '<pre>'; print_r($object); echo '</pre>'; exit;
			 */
				
			if(empty($response['errors']))
			{
				$response['message'] = 'Object is saved';

				Libraries_Event::trigger('beforeCrudSave', $sys_object, $object);

				$object->save();

				Libraries_Event::trigger('afterCrudSave', $sys_object, $object);
			}

			echo json_encode($response);
		}
	}

	public function search($sys_object_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		Libraries_View::getInstance()->sys_object = $sys_object;

		echo Libraries_View::getInstance()->setModule('crud')->load('search');
	}

	public function trash()
	{
		$return = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : SITE_ROOT_URI . '/crud/';
		$_SESSION['trash'] = isset($_SESSION['trash']) && $_SESSION['trash'] == 1 ? 0 : 1;

		header('location: ' . $return);
	}

	public function restore($sys_object_id, $row_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));

		$sql = "UPDATE {$sys_object->table_name}
				SET is_deleted = 0
				WHERE id = ?";
		$data = array($row_id);

		Libraries_Db_Factory::getDb()->execute($sql, $data);
	}
}