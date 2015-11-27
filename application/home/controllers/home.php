<?php

class Home_Controllers_Home extends Libraries_Controller
{
	public function index()
	{
		$where = array();
		$all_projects_ids = array();
		$project_ids = array();
		
		
		// Load All projects //
		$sql = "SELECT id
				FROM projects";

		$data = array();
		
		$obj_all_projects_ids = Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);	// id-s from all projects
				
		foreach ($obj_all_projects_ids as $obj) {
			$all_projects_ids[] = $obj->id;		// getting array of id-s of projects
		}
		
		
		// Loading sectors select //
		$sector = new Home_Models_Sector();
		$sectors = $sector->search();
		Libraries_View::getInstance()->sectors = $sectors;
		
		
		// Loading regions-cities //
		$city = new Home_Models_City();
		$order = array();
		$order[] = array('name', 'ASC');
		$cities = $city->search(array(), $order);
		Libraries_View::getInstance()->cities = $cities;


		// Search by project title //
		if(isset($_POST['name']) && !empty($_POST['name']))
		{
			$where[] = array('AND', 'title', 'LIKE', '%' . $_POST['name'] . '%');
		}
		
		// Sector search //
		if(isset($_POST['sectors']))
		{
			$sectors = join(',', array_filter($_POST['sectors'], 'intval'));
				
			$sql = "SELECT project_id, COUNT(id) AS 'sectors_count'
					FROM projects_sectors
					WHERE sector_id IN ({$sectors})
					GROUP BY project_id
					HAVING sectors_count = " . count($_POST['sectors']);

			$data = array();
				
			$obj_ids_projects_by_sectors = Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);	// project_id-s from table project_sectors
			
			$ids_projects_by_sectors = array();
			foreach ($obj_ids_projects_by_sectors as $obj) {
				$ids_projects_by_sectors[] = $obj->project_id;		// getting array of id-s of projects
			}
							
			$project_ids = array_intersect($all_projects_ids, $ids_projects_by_sectors);
		}

		// Regions=Cities search //
		if(isset($_POST['regions-select']))
		{
			$cities = join(',', array_filter($_POST['regions-select'], 'intval'));
				
			$sql = "SELECT project_id, COUNT(id) AS 'cities_count'
					FROM cities_projects
					WHERE city_id IN ({$cities},23)
					GROUP BY project_id
					HAVING cities_count = " . count($_POST['regions-select']);

			$data = array();
				
			$obj_ids_projects_by_cities = Libraries_Db_Factory::getDb()->fetchAll($sql, $data, Libraries_Db_Adapter::FETCH_TYPE_CLASS);	// project_id-s from table cities_projects
			$ids_projects_by_cities = array();
			foreach ($obj_ids_projects_by_cities as $obj) {
				$ids_projects_by_cities[] = $obj->project_id;		// getting array of id-s of projects
			}
			
			$project_ids = array_intersect($all_projects_ids, $ids_projects_by_cities);
		}
		
		if(!empty($_POST))
		{
			if(empty($project_ids))
			{
				$where[] = array('AND', '1', '=', 1);
			}
			else
			{
				$where[] = array('AND', 'id', 'IN', $project_ids);
			}
		}
		
		//echo '<pre>'; print_r($where); echo '</pre>';

		$project = new Home_Models_Project();
		$projects = $project->search($where);
		
		//echo '<pre>'; print_r($projects); echo '</pre>';

		Libraries_View::getInstance()->projects = $projects;

		echo Libraries_View::getInstance()->setModule('home')->load('home');
	}
}