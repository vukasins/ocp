<?php

class Home_Models_Project extends Libraries_Db_Mysql_Model
{
	public function __construct(array $data = array()) {
		parent::__construct("projects", $data);
	}

	public function getCitiesForProject()
	{
		$sql = "SELECT cities.*
				FROM cities_projects
				INNER JOIN cities ON cities.id = cities_projects.city_id
				WHERE 	cities_projects.is_deleted = 0 AND
						cities.is_deleted = 0 AND
						cities_projects.project_id = ?";
		$data = array($this->id);
		
		return  Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);
	}
	
	public function getSectorsForProject()
	{
		$sql = "SELECT sectors.*
				FROM projects_sectors
				INNER JOIN sectors ON sectors.id = projects_sectors.sector_id
				WHERE 	projects_sectors.is_deleted = 0 AND
						sectors.is_deleted = 0 AND
						projects_sectors.project_id = ?";
		$data = array($this->id);
		
		return  Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);
	}
}