<?php

/**
 * Base controller. This class have to be parent class of all controllers
 * @author Lajavi Krelac
 *
 */
class Libraries_Controller 
{
    /**
     * @var string Module we are in
     */
    protected $module = null;
    
    /**
     * @var Libraries_View
     */
    protected $view = null;
    
    /**
     * 
     * @var Libraries_Db_Adapter
     */
    protected $db = null;
    
    /**
     * @var Libraries_i18n
     */
    protected $i18n = null;
    
    public function __construct() 
    {
        $this->module = $this->getModuleFromControllerName();
        $this->view = new Libraries_View($this->module);
        $this->db = Libraries_Db_Factory::factory(Config_Db_Factory::DRIVER);
        
        $this->i18n = new Libraries_i18n();
    }
    
    /**
     * Get module name from controller class name
     */
    protected function getModuleFromControllerName() 
    {
        $controller_name = get_class($this);
        return strtolower(preg_replace('/_(.*?)$/i', '', $controller_name));
    }
}