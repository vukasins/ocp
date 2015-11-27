<?php

class Libraries_Event
{
	protected static $event_handlers = array();
	
	public static function registerEvents($root_dir = APPLICATION_ROOT_DIR)
	{
		$application_root_dir = $root_dir;
		$dir = dir($application_root_dir);
		
		while(($file = $dir->read()) !== false)
		{
			if(preg_match('/^\.{1,}$/', $file))
			{
				continue;
			}
			
			$module_dir = $application_root_dir . DIRECTORY_SEPARATOR . $file . '/';
			
			if(is_dir($module_dir))
			{
				$events_file = $module_dir . 'events.php';
				if(file_exists($events_file))
				{
					require_once($events_file);
				}
			}
		}
	}
	
	public static function registerEventHandler($event, $class, $method)
	{
		if(is_callable(array($class, $method)))
		{
			$item = new stdClass();
			$item->class = $class;
			$item->method = $method;
			
			if(!isset(self::$event_handlers[$event]))
			{
				self::$event_handlers[$event] = array();
			}
			
			self::$event_handlers[$event][] = $item;
			
			return true;
		}
		
		return false;
	}
	
	public static function trigger($event)
	{
		if(array_key_exists($event, self::$event_handlers))
		{
			$arguments = func_get_args();
			array_shift($arguments);
			
			$event_handlers = self::$event_handlers[$event];
			foreach($event_handlers as $event_handler)
			{
				call_user_func_array(array($event_handler->class, $event_handler->method), $arguments);
			}
		}
	}
}