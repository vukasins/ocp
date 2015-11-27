<?php

class Libraries_Environment_Factory
{
    public static function getEnvironment()
    {
        $class_name = 'Libraries_Environment_' . ucfirst(Config_Environment::ACTIVE_ENVIRONMENT);
        
        if(class_exists($class_name) && (new $class_name instanceof Libraries_Environment_Adapter))
        {
            return call_user_func(array(new $class_name, 'init'));
        }
        else 
        {
            throw new Exception($class_name . ' is not instance of Libraries_Environment_Adapter');
        }
    }
}