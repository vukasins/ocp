<?php

class Testera_Controllers_Vin extends Libraries_Controller
{
	public function render($widget, $widget_instance, $row)
	{
		echo $this->view->load('vreme_i_novac');
	}
}