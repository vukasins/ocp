<?php

class Page_Controllers_Widget extends Admin_Libraries_Controllers_Secure
{
	public function updateWidgetInstance()
	{
		if(!isset($_POST['id_widget_instance']))
		{
			return;
		}
		
		if(!isset($_POST['id_row']))
		{
			return;
		}
		
		$id_widget_instance = $_POST['id_widget_instance'];
		$id_row = $_POST['id_row'];
		
		$widget_instance = new Page_Models_Page_Widget_Instance();
		$widget_instance->load($id_widget_instance);
		
		$widget_instance->id_row = $id_row;
		$widget_instance->save();
	}
	
	public function updateWidgetInstanceOrder()
	{
		//echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
		foreach($_POST['widget_instances'] as $widget_instance_data)
		{
			$widget_instance = new Page_Models_Page_Widget_Instance();
			$widget_instance->load($widget_instance_data['id_widget_instance']);
			$widget_instance->area_name = $widget_instance_data['region'];
			$widget_instance->order_index = $widget_instance_data['index'];
			$widget_instance->save();
		}
	}
	
	public function loadAvailableWidgets()
	{
		$widget = new Page_Models_Page_Widget();
		$widgets = $widget->search();
		
		foreach($widgets as $widget)
		{
			echo '<a href="#" class="new-widget" data-widget-id="' . $widget->id . '">' . $widget->title . '</a><br />';
		}
	}
	
	public function saveNewWidgetInstance()
	{
		$id_page = $_POST['id_page'];
		$id_widget = $_POST['id_widget'];
		
		$widget = new Page_Models_Page_Widget();
		$widget->load($id_widget);
		
		$widget_instance = new Page_Models_Page_Widget_Instance();
		$widget_instance->id_page = $id_page;
		$widget_instance->id_page_widget = $widget->id;
		$widget_instance->id_sys_object = $widget->id_sys_object;
		$widget_instance->area_name = 'home_right';
		$widget_instance->save();
	}
}