<?php

class Page_Libraries_Widget
{
	public static function render($widget_area)
	{
		$view = Libraries_View::getInstance();
		
		$page = $view->getSharedData('_SYSTEM_PAGE');
		$page_template = $view->getSharedData('_SYSTEM_PAGE_TEMPLATE');
		
		$where = array();
		$where[] = array('AND', 'id_page', '=', $page->id);
		$where[] = array('AND', 'area_name', '=', $widget_area);
		
		$order = array();
		$order[] = array('order_index', 'ASC');
		
		$widget_instance = new Page_Models_Page_Widget_Instance();
		$widget_instances = $widget_instance->search($where, $order);
		
		foreach($widget_instances as $widget_instance)
		{
			$widget = new Page_Models_Page_Widget();
			$widget->load($widget_instance->id_page_widget);
			
			$sys_object = new Crud_Models_Object();
			$sys_object->load($widget->id_sys_object);
			
			$row = new Libraries_Db_Mysql_Model($sys_object->table_name);
			$row->load($widget_instance->id_row);
			
			$widget_class_name = $widget->class_name;

			/*
			echo '<pre>'; print_r($widget); echo '</pre>';
			echo '<pre>'; print_r($widget_instance); echo '</pre>'; exit;
			*/
			
			echo '<div class="widget" data-widget-id="' . $widget->id . '" data-widget-instance-id="' . $widget_instance->id . '" data-widget-object-id="' . $widget->id_sys_object . '" data-widget-row-id="' . $widget_instance->id_row . '">';
			call_user_func_array(array(new $widget_class_name, 'render'), array($widget, $widget_instance, $row));
			echo '</div>';
		}
	}
}