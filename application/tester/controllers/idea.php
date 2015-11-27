<?php

class Tester_Controllers_Idea extends Libraries_Controller implements Page_Interfaces_Widget
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('idea');
	}
}