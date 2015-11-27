<?php

class Controls_Libraries_Controls_Text extends Controls_Libraries_Control
{
	public static $edit_file = '/text/edit';
	public static $list_file = '/label/list';
	public static $search_file = '/text/search';

	public function modifyForm(Crud_Models_Field $field)
	{
		Libraries_View::getInstance()->setModule('controls');
		Libraries_View::getInstance()->field = $field;
		Libraries_View::getInstance()->properties = json_decode($field->sys_control_properties);

		return Libraries_View::getInstance()->load('/text/form');
	}
}