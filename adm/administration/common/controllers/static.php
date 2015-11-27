<?php

class Common_Controllers_Static extends Libraries_Controller implements Page_Interface_Widget
{
	public function index(array $properties = array())
	{
		$this->view->properties = $properties;
		
		return $this->view->load('static');
	}
} 