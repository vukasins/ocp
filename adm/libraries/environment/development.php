<?php

class Libraries_Environment_Development extends Libraries_Environment_Adapter
{
    protected $show_errors = true;

    public function init()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }
}