<?php

class Controls_Libraries_Controls_Foreignkey extends Controls_Libraries_Control
{
	public static $edit_file = '/foreignkey/edit';
	public static $list_file = '/foreignkey/list';
	public static $search_file = '/foreignkey/search';

	public function modifyForm(Crud_Models_Field $field)
	{
		Libraries_View::getInstance()->setModule('controls');
		Libraries_View::getInstance()->field = $field;
		Libraries_View::getInstance()->properties = json_decode($field->sys_control_properties);

		return Libraries_View::getInstance()->load('/foreignkey/form');
	}
}