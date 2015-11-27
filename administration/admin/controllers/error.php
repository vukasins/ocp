<?php

class Admin_Controllers_Error extends Libraries_Controller
{
	public function index()
	{
		$content = Libraries_View::getInstance()->setModule('admin')->load('404');

		Libraries_Layout::getInstance()->setTheme('admin');
		
		if(Admin_Libraries_Admin::getLogedUser()->id > 0)
		{
			Libraries_Layout::getInstance()->setLayout('admin');
		}
		else
		{
			Libraries_Layout::getInstance()->setLayout('error');
		}
		
		Libraries_Layout::getInstance()->setRegionContent('content', $content);

		Libraries_Layout::getInstance()->render();
	}
}