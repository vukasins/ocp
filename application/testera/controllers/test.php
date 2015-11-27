<?php

class Testera_Controllers_Test extends Libraries_Controller
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('proba');
	}
}