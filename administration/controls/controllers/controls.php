<?php

class Controls_Controllers_Controls extends Admin_Libraries_Controllers_Secure
{
	public function getModifyForm()
	{
		$field_id = intval($_POST['field_id']);
		$control_id = intval($_POST['control_id']);
		
		$field = new Crud_Models_Field();
		$field->load($field_id);
		$field->loadValidators();
		$field->loadControl();
		
		$control = new Controls_Models_Control();
		$control->load($control_id);
		
		echo call_user_func(array(new $control->class, 'modifyForm'), $field);
	}
}