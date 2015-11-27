<?php

class Admin_Controllers_Permission extends Admin_Libraries_Controllers_Secure implements Crud_Interfaces_Crud
{
	public function content($sys_object_id)
	{
		$sys_object = new Crud_Models_Object();
		$sys_object->load(intval($sys_object_id));
		$sys_object->loadFieldsForObject();

		if($sys_object->is_system == 1 && $this->user->role->safe_title != 'administrator')
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			exit;
		}

		if(!$this->user->role->canExecuteAction('can_view_' . $sys_object->table_name))
		{
			echo '<script>window.location="' . SITE_ROOT_URI . '/admin/error/' . '"</script>';
			exit;
		}
		
		$order = array();
		$order[] = array('title', 'ASC');
		
		$role = new Libraries_Db_Mysql_Model('adm_user_role');
		$roles = $role->search(array(), $order);
		
		if(isset($_POST) && !empty($_POST))
		{
			foreach($roles as $role)
			{
				$sql = "DELETE 
						FROM adm_user_role_permission
						WHERE id_adm_user_role = ?";
				$data = array($role->id);
				
				Libraries_Db_Factory::getDb()->execute($sql, $data);
				
				foreach($_POST as $action => $data)
				{
					$permission = new Libraries_Db_Mysql_Model('adm_user_role_permission');
					$permission->id_adm_user_role = $role->id;
					$permission->action = $action;
					$permission->is_active = (array_key_exists($role->id, $data) && $data[$role->id] == 1 ? 1 : 0);
										
					$permission->save();
				}
			}
			
			Libraries_Flashdata::set('saved', __('Permissions is saved'));
		}
		
		$order = array();
		$order[] = array('table_name', 'ASC');
		
		$where = array();
		$where[] = array('AND', 'is_system', '!=', 1);
		
		$objects = $sys_object->search($where, $order);
		
		Libraries_View::getInstance()->roles = $roles;
		Libraries_View::getInstance()->objects = $objects;
		Libraries_View::getInstance()->saved_status = Libraries_Flashdata::get('saved');
		
		$content = Libraries_View::getInstance()->setModule('admin')->load('permissions');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}

	public function modify($sys_object_id, $row_id = '')
	{

	}

	public function save($sys_object_id, $row_id = '')
	{

	}
}