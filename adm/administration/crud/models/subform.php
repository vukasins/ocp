<?php

class Crud_Models_Subform extends Libraries_Db_Mysql_Model
{
    public function __construct(array $data = array())
    {
        parent::__construct('sys_subform', $data);
    }
}