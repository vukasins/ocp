<?php

interface Crud_Interfaces_Crud
{
	public function content($sys_object_id);
	
	public function modify($sys_object_id, $row_id = '');
	
	public function save($sys_object_id, $row_id = '');
}