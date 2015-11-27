<?php

class Page_Models_Page_Widget_Instance extends Libraries_Db_Mysql_Model
{
    public function __construct(array $data = array())
    {
        parent::__construct('page_widget_instance', $data);
    }
}