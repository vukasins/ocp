<?php

class Page_Models_Page extends Libraries_Db_Mysql_Model
{
    public function __construct(array $data = array())
    {
        parent::__construct('page', $data);
    }
    
    /**
     * 
     * @param int $id_page
     * @return Page_Models_Page
     */
    public function loadPublishedPageById($id_page)
    {
    	$sql = "SELECT *
    			FROM page
    			WHERE	is_deleted = 0 AND
    					is_published = 1 AND
    					id = ?";
    	
    	$data = array();
    	$data[] = $id_page;
    	
    	$this->data = $this->db->fetchRow($sql, $data);
    	
    	return $this;
    }
    
    /**
     * @return Page_Models_Page
     */
    public function loadHomePage()
    {
    	$sql = "SELECT *
    			FROM page
    			WHERE	is_deleted = 0 AND
    					is_published = 1 AND
    					is_home_page = 1";
    	
    	$this->data = $this->db->fetchRow($sql);
    	
    	return $this;
    }
}