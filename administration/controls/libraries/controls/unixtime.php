<?php

class Controls_Libraries_Controls_Unixtime extends Controls_Libraries_Control
{
	public static $edit_file = '/datetime/edit';
	public static $list_file = '/unixtime/list';
	public static $search_file = '/unixtime/search';

	public function modifyForm(Crud_Models_Field $field)
	{
	}
}