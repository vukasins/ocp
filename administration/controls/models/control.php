<?php

class Controls_Models_Control extends Libraries_Db_Mysql_Model
{
    public function __construct(array $data = array())
    {
        parent::__construct('sys_control', $data);
    }
}