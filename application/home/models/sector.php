<?php

class Home_Models_Sector extends Libraries_Db_Mysql_Model
{
	public function __construct(array $data = array()) {
		parent::__construct("sectors", $data);
	}
}