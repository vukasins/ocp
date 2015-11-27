<?php

class Admin_Controllers_Admin extends Admin_Libraries_Controllers_Secure
{
	public function index()
	{
		$content = Libraries_View::getInstance()->setModule('admin')->load('dashboard');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}

	public function profile()
	{
		if(isset($_POST) && !empty($_POST))
		{
			
			$this->user->email = $_POST['email'];
			
			if(!empty($_POST['password']) && $_POST['password'] == $_POST['repeat_password'])
			{
				$this->user->password = md5($_POST['password'] . $user->salt);
			}
			
			$this->user->save();
			
			Libraries_Flashdata::set('saved', __('Profile is saved'));
		}
		
		Libraries_View::getInstance()->user = $this->user;
		Libraries_View::getInstance()->saved_status = Libraries_Flashdata::get('saved');
		
		$content = Libraries_View::getInstance()->setModule('admin')->load('profile');

		Libraries_Layout::getInstance()->setTheme('admin');
		Libraries_Layout::getInstance()->setLayout('admin');
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}
}