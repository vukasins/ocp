<?php

class Tester_Controllers_Test extends Libraries_Controller implements Page_Interfaces_Widget
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('proba');
	}
}