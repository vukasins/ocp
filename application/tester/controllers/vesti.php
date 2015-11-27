<?php

class Tester_Controllers_Vesti extends Libraries_Controller implements Page_Interfaces_Widget
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('vesti');
	}
}