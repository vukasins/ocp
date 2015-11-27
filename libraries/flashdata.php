<?php

/**
 * Codeigniter like flashdata
 * 
 * @author Ludi Vujadin
 *
 */
class Libraries_Flashdata
{
	public static function set($key, $message)
	{
		if(!isset($_SESSION['flashdata']))
		{
			$_SESSION['flashdata'] = array();
		}
		
		if(!empty($key))
		{
			$_SESSION['flashdata'][$key] = $message;
		}
		else
		{
			return false;
		}
		
		return true;
	}
	
	public static function get($key)
	{
		if(isset($_SESSION['flashdata']) && is_array($_SESSION['flashdata']) && array_key_exists($key, $_SESSION['flashdata']))
		{
			$message = $_SESSION['flashdata'][$key];
			
			unset($_SESSION['flashdata'][$key]);
			
			return $message;
		}
		
		return null;
	}
}