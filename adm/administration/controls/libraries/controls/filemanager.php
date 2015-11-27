<?php

class Controls_Libraries_Controls_Filemanager extends Controls_Libraries_Control
{
	public static $edit_file = '/filemanager/edit';
	public static $list_file = '/filemanager/list';
	public static $search_file = '/text/list';

	public function modifyForm(Crud_Models_Field $field)
	{
		Libraries_View::getInstance()->setModule('controls');
		Libraries_View::getInstance()->field = $field;
		Libraries_View::getInstance()->properties = json_decode($field->sys_control_properties);

		return Libraries_View::getInstance()->load('/filemanager/form');
	}
}