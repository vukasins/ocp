<?php

abstract class Controls_Libraries_Control
{
	const CONTROL_TYPE_EDIT = 1;
	const CONTROL_TYPE_LIST = 2;
	const CONTROL_TYPE_SEARCH = 3;

	public static $edit_file = '/text/search';
	public static $list_file = '/text/search';
	public static $search_file = '/text/search';

	public abstract function modifyForm(Crud_Models_Field $field);

	public static function render($control, $object, $field, $row = array(), $index = '', $control_type = self::CONTROL_TYPE_EDIT)
	{
		if($control->isEmpty())
		{
			return '';
		}
		
		$control_class = $control->class;

		if($control_type == self::CONTROL_TYPE_EDIT)
		{
			$view_file = $control_class::$edit_file;
		}
		else if($control_type == self::CONTROL_TYPE_LIST)
		{
			$view_file = $control_class::$list_file;
		}
		else if($control_type == self::CONTROL_TYPE_SEARCH)
		{
			$view_file = $control_class::$search_file;
		}
		
		$control_view = Libraries_View::getInstance(true); // create new instance of view; only for controls
		$control_view->setModule('controls');

		$value = '';
		if(!empty($row))
		{
			$value = $row->{$field->field_name};
		}

		$control_view->field = $field; // set field data
		$control_view->value = $value; // set value
		$control_view->row = $row; // set value
		$control_view->control_properties = json_decode($field->sys_control_properties); // set control properties; ex. table for autocomplete
		$control_view->object = $object;
		$control_view->index = intval($index) + 1;

		return $control_view->load($view_file); // load control file
	}
}