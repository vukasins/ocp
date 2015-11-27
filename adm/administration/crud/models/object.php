<?php

class Crud_Models_Object extends Libraries_Db_Mysql_Model
{
    /**
     * Field list
     * @var array
     */
    public $sys_field_list = array();

    public function __construct(array $data = array())
    {
        parent::__construct('sys_object', $data);
    }

    /**
     *
     * @return Objectmanager_Models_Object
     */
    public function loadFieldsForObject()
    {
        $where = array();
        $order = array(array('order_index', 'DESC'));

        // get all fields for object
        $where[] = array('AND', 'id_sys_object', '=', intval($this->id));

        $sys_field = new Crud_Models_Field();
        $sys_field_list = $sys_field->search($where, $order);
        
        foreach ($sys_field_list as $sys_field)
        {
            $this->sys_field_list[$sys_field->field_name] = $sys_field;
        }
        
        return $this;
    }
    
    /**
     * 
     */
    public function getFieldData($field_name)
    {
       if(empty($this->sys_field_list))
       {
           $this->loadFieldsForObject();
       } 
       
       return $this->sys_field_list[$field_name];
    }
}