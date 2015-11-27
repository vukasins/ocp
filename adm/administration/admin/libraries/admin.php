<?php

class Admin_Libraries_Admin
{
	/**
	 * Login selected user
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public static function login($username, $password)
	{
		$where = array();
		$where[] = array('AND', 'username', '=', $username);
			
		$user = new Admin_Models_Admin();
		$users = $user->search($where);
    	
		foreach($users as $user)
		{    
			if(trim($user->password) == trim(md5($_POST['password'] . $user->salt)))
			{
				$_SESSION['adm_user'] = $user->id;
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * User logout
	 * @return bool
	 */
	public static function logout()
	{
		$_SESSION['adm_user'] = null;
		unset($_SESSION['adm_user']);
		
		return true;
	}
	
	/**
	 * @return Admin_Libraries_Admin
	 */
	public static function getLogedUser()
	{
		if(!self::isLoged())
		{
			return new Admin_Models_Admin();
		}
		
		$user = new Admin_Models_Admin();
		return $user->load($_SESSION['adm_user']);
	}
	
	/**
	 * Check if user is loged
	 * @return bool
	 */
	public static function isLoged()
	{
		if(!isset($_SESSION['adm_user']))
		{
			return false;
		}
		
		$user = new Admin_Models_Admin();
		$user->load($_SESSION['adm_user']);
		
		if($user->isEmpty())
		{
			return false;
		}
		
		
		return true;
	}
}