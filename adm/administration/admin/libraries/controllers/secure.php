<?php

class Admin_Libraries_Controllers_Secure extends Libraries_Controller
{
	protected $user = null;
	
	public function __construct()
	{
		parent::__construct();

		if(!Admin_Libraries_Admin::isLoged())
		{
			header('location: ' . SITE_ROOT_URI . '/admin/auth/login/');
			exit;
		}

		$this->user = Admin_Libraries_Admin::getLogedUser();
		$this->user->loadRole();
	}
}