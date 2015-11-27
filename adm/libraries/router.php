<?php

/**
 * 
 * @author Lajavi Krelac
 *
 */
class Libraries_Router
{
    private static $instance = null;

    private function __clone()
    {
    }

    private function __construct()
    {
    }
    
    /**
     * For now, this method just calls action with arguments
     * @param Libraries_Request $request
     */
    public function route(Libraries_Request $request) 
    {
        $controller = $request->getController();
        return call_user_func_array(array(new $controller, $request->getAction()), $request->getArguments());
    }

    /**
     * @return Libraries_Router
     */
    public static function getInstance()
    {
        if(empty(self::$instance) || !(self::$instance instanceof Libraries_Router))
        {
            self::$instance = new Libraries_Router();
        }

        return self::$instance;
    }
}