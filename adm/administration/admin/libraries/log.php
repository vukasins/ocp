<?php

class Admin_Libraries_Log
{
	private static $instance = null;

	/**
	 *
	 * @param string $action
	 * @param string $content
	 * @return Libraries_Db_Mysql_Model
	 */
	public function logAction($action, $content)
	{
		$this->fifo();
		
		$log = new Libraries_Db_Mysql_Model('sys_log');
		$log->id_adm_user = Admin_Libraries_Admin::getLogedUser()->id;
		$log->action = $action;
		$log->content = $content;
		$log->create_date = time();
		$log->save();

		return $log;
	}

	/**
	 * 
	 * @return bool
	 */
	private function fifo()
	{
		$sql = "SELECT COUNT(id)
				FROM sys_log";
		$count = Libraries_Db_Factory::getDb()->fetchColumn($sql);
		
		if($count > Config_Environment::MAX_LOG_ENTRIES)
		{
			$sql = "DELETE FROM
					sys_log
					ORDER BY id
					LIMIT " . ($count - Config_Environment::MAX_LOG_ENTRIES);
			if(Libraries_Db_Factory::getDb()->execute($sql))
			{
				return true;
			}
			
			return false;
		}
		
		return true;
	}

	/**
	 *
	 * @return Admin_Libraries_Log
	 */
	public static function getInstance()
	{
		return (self::$instance != null ? self::$instance : self::$instance = new self);
	}
}