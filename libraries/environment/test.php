<?php

class Libraries_Environment_Test extends Libraries_Environment_Adapter
{
    protected $show_errors = false;

    public function init()
    {
        ini_set('display_errors', 0); // don't display errors
        error_reporting(E_ALL); // log all errors
    }
}