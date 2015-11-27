<?php

class Admin_Models_Admin extends Libraries_Db_Mysql_Model
{
	public $role = null;
	
	public function __construct(array $data = array())
	{
		parent::__construct('adm_user', $data);
	}
	
	public function loadRole()
	{
		$this->role = new Admin_Models_Admin_Role();
		$this->role->load($this->id_adm_user_role);
		
		return $this;
	}
}