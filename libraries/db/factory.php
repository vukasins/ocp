<?php

/**
 * 
 * @author Lajavi Krelac
 *
 */
class Libraries_Db_Factory 
{
    private static $db = null;

    /**
     * Create DB instance
     * @param string $driver
     * @throws Exception
     * @return Libraries_Db_Adapter
     */
    public static function factory($driver)
    {
        $class_name = 'Libraries_Db_' . ucfirst(strtolower($driver)) . '_Driver'; // create DB class name
        
        // check if driver exists
        if(!class_exists($class_name))
        {
            throw new Exception("Can't find class " . $class_name);
        }
        
        return (self::$db = call_user_func(array($class_name, 'getInstance')));
    }
    
    /**
     * Get initialized DB
     * @throws Exception
     * @return Libraries_Db_Adapter
     */
    public static function getDb()
    {
        if(empty(self::$db))
        {
            throw new Exception("Factory is not initialized");
        }
        
        return self::$db;
    }
}