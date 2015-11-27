<?php

class Testera_Controllers_Publication extends Libraries_Controller
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('publication');
	}
}