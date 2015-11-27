<?php

/**
 * 
 * @author Lajavi Krelac
 *
 */
class Libraries_Request
{
    private static $instance = null;

    private $module = '';
    private $controller = '';
    private $action = '';
    private $args = array();

    private function __clone()
    {
    }

    private function __construct()
    {
        if(isset($_SERVER['PATH_INFO'])) 
        {
            $url_chunks = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        }
        else 
        {
            $url_chunks = '';
        }
        
        //echo '<pre>'; print_r($_SERVER); exit;
        
        if(!empty($url_chunks) && !empty($url_chunks[0]))
        {
            // firs item of array is name of modules
            if(isset($url_chunks[0]) && self::isModule($url_chunks[0])) 
            {
                $this->module = array_shift($url_chunks);
            }
            // or not
            else 
            {
                $this->module = Config_Request::DEFAULT_MODULE;
            }
            
            // now, first item is name of controller
            if(isset($url_chunks[0]) && self::isController($url_chunks[0]))
            {
                $this->controller = $this->createControllerClassName(array_shift($url_chunks));
            }
            // and again... or not...
            else 
            {
                $this->controller = $this->createControllerClassName($this->module);
            }
            
            // and now!!! camera, ACTION
            if(isset($url_chunks[0]) && self::isAction($url_chunks[0]))
            {
                $this->action = array_shift($url_chunks);
            }
            // or just a troll
            else 
            {
                $this->action = Config_Request::DEFAULT_ACTION;
            }
            
            $this->args = $url_chunks;
        }
        else 
        {
            // ok you troll... we have to use default values now
            $this->module = Config_Request::DEFAULT_MODULE;
            $this->controller = $this->createControllerClassName($this->module);
            $this->action = Config_Request::DEFAULT_ACTION;
            $this->args = array();
        }
    }

    /**
     * Check if given name is module
     *
     * @param string $module_name
     * @return bool
     */
    private function isModule($module_name)
    {
    	if(is_dir(APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $module_name))
    	{
        	return (is_dir(APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $module_name));
    	}
    	elseif(is_dir(ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $module_name))
    	{
    		return (is_dir(ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $module_name));
    	}
    }
    
    /**
     * Check if given string is controller
     * @param string $controller_name
     * @return bool
     */
    private function isController($controller_name) 
    {
        if(empty($this->module)) return false;
        
        $controller_class_name = $this->createControllerClassName($controller_name);
        return class_exists($controller_class_name);
    }
    
    /**
     * Check if this is valid method in controller
     * @param string $action_name
     * @return bool
     */
    private function isAction($action_name) 
    {
        return method_exists($this->controller, $action_name);
    }
    
    /**
     * Create controller class name based on given string 
     * @param string $controller_name
     * @return string
     */
    private function createControllerClassName($controller_name)
    {
        $name_separator = Libraries_Loader::getInstance()->getNameSeparator();

        $controller_class_name = $this->module . $name_separator . 'controllers' . $name_separator . $controller_name;
        $controller_class_name = str_replace('-', $name_separator, $controller_class_name);
        $controller_class_name = Libraries_Loader::getInstance()->convertToClassName($controller_class_name);
        
        return $controller_class_name;
    }
    
    /**
     * @return string
     */
    public function getModule() 
    {
        return $this->module;
    }
    
    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * @return string
     */
    public function getAction() 
    {
        return $this->action;
    }
    
    public function getArguments()
    {
        return $this->args;
    }

    /**
     * @return Libraries_Request
     */
    public static function getInstance()
    {
        if(empty(self::$instance) || !(self::$instance instanceof Libraries_Request))
        {
            self::$instance = new Libraries_Request();
        }

        return self::$instance;
    }
}