<?php

class Page_Controllers_Page extends Libraries_Controller
{
	public function index()
	{
		$arguments = Libraries_Request::getInstance()->getArguments();
		$last_argument_part = end($arguments);
		$id_page = intval(preg_replace('/^(.*?)(\d{1,})\.html$/i', '$2', $last_argument_part));

		$page = new Page_Models_Page();

		if(!empty($id_page))
		{
			$page->loadPublishedPageById($id_page);
		}
		else 
		{
			$page->loadHomePage();
		}
		
		$page_template = new Page_Models_Page_Template();
		$page_template->load($page->id_page_template);
		
		$this->view->setSharedData('_SYSTEM_PAGE', $page);
		$this->view->setSharedData('_SYSTEM_PAGE_TEMPLATE', $page_template);

		Libraries_Layout::getInstance()->setTheme('demo');
		Libraries_Layout::getInstance()->setLayout($page_template->view_name);

		Libraries_Layout::getInstance()->render();
	}
}