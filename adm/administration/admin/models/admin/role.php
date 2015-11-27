<?php

class Admin_Models_Admin_Role extends Libraries_Db_Mysql_Model
{
	public function __construct(array $data = array())
	{
		parent::__construct('adm_user_role', $data);
	}
	
	public function canExecuteAction($action)
	{
		$sql = "SELECT * 
				FROM adm_user_role_permission
				WHERE	is_deleted = 0 AND
						action = ? AND
						id_adm_user_role = ?";
		$data = array();
		$data[] = $action;
		$data[] = $this->id;
		
		$response = Libraries_Db_Factory::getDb()->fetchRow($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);
		
		if(empty($response) || intval($response->is_active) !== 0)
		{
			return true;
		}

		return false;
	}
}