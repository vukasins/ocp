<?php

class Common_Libraries_Pagination
{
	public static function render($items_count, $items_per_page, $current_page, $url)
	{
		$view = new Libraries_View('common');

		$number_of_pages = ceil($items_count / $items_per_page);
		$max_number_of_pages = $number_of_pages;

		$pagination_start = 1;

		if($number_of_pages > 5)
		{
			if($current_page == 1)
			{
				$pagination_start = 1;
				$number_of_pages = 5;
			}
			else
			{
				if($current_page - 2 <= 1)
				{
					$pagination_start = 1;
					$number_of_pages = 5;
				}
				else
				{
					if($current_page + 2 >= $number_of_pages)
					{
						$pagination_start = $number_of_pages - 4;
					}
					else
					{
						$pagination_start = $current_page - 2;
						$number_of_pages = $current_page + 2;
					}
				}
			}
		}
		
		$get_results = '';
		if(!empty($_GET))
		{
			$get_results = '?';
			foreach($_GET as $key => $value)
			{
				$get_results .= $key . '=' . $value . '&';
			}
			
			$get_results = rtrim($get_results, '&');
		}

		$view->items_count = $items_count;
		$view->items_per_page = $items_per_page;
		$view->current_page = $current_page;
		$view->url = $url;
		$view->number_of_pages = $number_of_pages;
		$view->pagination_start = $pagination_start;
		$view->get_results = $get_results;
		$view->max_number_of_pages = $max_number_of_pages;

		if($number_of_pages > 1)
		{
			return $view->load('pagination');
		}
		
		return '';
	}
}