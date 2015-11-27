<?php

/**
 * Custom Crud example
 * @author Ludi Vujadin
 *
 */
class Common_Controllers_CC extends Libraries_Controller implements Crud_Interfaces_Crud
{
	public function modify($sys_object_id, $row_id = '')
	{
		echo 'modify';
	}
	
	public function save($sys_object_id, $row_id = '')
	{
		echo 'save';
	}
}