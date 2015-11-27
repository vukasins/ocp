<?php

/**
 * Description of Config_Environment
 *
 * @author reasta
 */

class Config_Environment 
{
    /**
     * Available types of environment
     * @var enum(development | test | production)
     */
    const ACTIVE_ENVIRONMENT = 'development';
    
    const DEFAULT_ITEMS_PER_PAGE = 50;
    
    const MAX_LOG_ENTRIES = 300;
}