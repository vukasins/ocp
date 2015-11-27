<?php

class Admin_Controllers_Auth extends Libraries_Controller
{
	public function login()
	{
		if(isset($_POST['username']))
		{
			$where = array();
			$where[] = array('AND', 'content', '=', $_POST['username']);
			$where[] = array('AND', 'action', '=', 'login_failure');
			$where[] = array('AND', 'create_date', '>=', (time() - (60 * 60)));
			
			$order = array();
			$order[] = array('create_date', 'desc');
			
			$log = new Libraries_Db_Mysql_Model('sys_log');
			$access_failures = $log->search($where, $order);
			
			if(count($access_failures) >= 3)
			{
				header('location: ' . SITE_ROOT_URI . '/admin/error/');
				exit;
			}			
			
			Admin_Libraries_Log::getInstance()->logAction('login_attempt', $_POST['username']);
			
			$username = $_POST['username'];
			$password = $_POST['password'];
				
			$is_login_success = Admin_Libraries_Admin::login($username, $password);
			$is_loged = Admin_Libraries_Admin::isLoged();
				
			if($is_login_success && $is_loged)
			{
				Admin_Libraries_Log::getInstance()->logAction('login_success', $_POST['username']);
				
				header('location:' . SITE_ROOT_URI . '/admin/');
				exit;
			}
			
			Admin_Libraries_Log::getInstance()->logAction('login_failure', $_POST['username']);
		}

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('login');

		Libraries_Layout::getInstance()->render();
	}

	public function logout()
	{
		Admin_Libraries_Admin::logout();

		header('location:' . SITE_ROOT_URI . '/admin/');
		exit;
	}
}