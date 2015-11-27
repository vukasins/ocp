<?php

/**
 *
 * Set system environment
 * @author reasta
 * @author Lajavi Krelac
 *
 */
abstract class Libraries_Environment_Adapter
{
    protected $show_errors = false;

    public abstract function init();

    /**
     *
     * Return name of active environment
     * @return string
     */
    public final function getEnvironmentName()
    {
        return Config_Environment::ACTIVE_ENVIRONMENT;
    }

    /**
     * 
     * Displays are errors turn on
     * @return string
     */
    public function getErrorStatus()
    {
        return ($this->show_errors ? "errors are turned ON" : "errors are turned OFF");
    }
}