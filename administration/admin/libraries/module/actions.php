<?php

class Admin_Libraries_Module_Actions
{
	private static $instance = null;

	private $action_files = array();
	private $actions = array();
	
	/**
	 * @return Admin_Libraries_Module_Actions
	 */
	public function registerActionFiles()
	{
		$dir = dir(APPLICATION_ROOT_DIR);
		while(($module_name = $dir->read()) !== false)
		{
			if(preg_match('/^\./', $module_name))
			{
				continue;
			}

			$module_dir = dir(APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $module_name . DIRECTORY_SEPARATOR);
			while(($file = $module_dir->read()) !== false)
			{
				if($file != 'actions.json')
				{
					continue;
				}
				
				$this->action_files[] = $module_dir->path . $file;
			}
		}
		
		return $this;
	}
	
	public function prepareActionFiles()
	{
		$user = Admin_Libraries_Admin::getLogedUser();
		$user->loadRole(); 
		
		foreach($this->action_files as $action_file)
		{
			$json = file_get_contents($action_file);
			$action_data = json_decode($json);
			
			foreach($action_data as $action_group)
			{
				if(!array_key_exists($action_group->group, $this->actions))
				{
					$this->actions[$action_group->group] = array();
				}
				
				if($action_group->level == $user->role->safe_title)
				{
					$this->actions[$action_group->group][] = $action_group;
				}
				
				if(empty($this->actions[$action_group->group]))
				{
					unset($this->actions[$action_group->group]);
				}
			}
		}
		
		return $this;
	}
	
	public function getActions()
	{
		return $this->actions;
	}

	/**
	 * @return Admin_Libraries_Module_Actions
	 */
	public static function getInstance()
	{
		return (empty(self::$instance) ? self::$instance = new self() : self::$instance);
	}
}