<?php

/**
* Categories Controller
*/
class Categories_Controller extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
	
		$this->template->this_page = 'categories';
		$this->template->content = new View('admin/categories');
		$this->template->content->title = 'Categories';
				
		// Total Categories
		$this->template->content->categories_total = ORM::factory('incident')->count_all();		
	}
	
	function index($page = 1)
	{		
		// Total Reports
		$this->template->content->reports_total = ORM::factory('incident')->count_all();
		
		//Get the incidents/reports list
		$tot = ORM::factory('incident')->count_all();

		//Pagination configuration
		$num_per_page = 10;

		//Setup pagination
		$pagination = new Pagination(array(
				'base_url' => "page/items",
				'uri_segment' => "page",
				'total_items'=> $tot,
				'style' => "digg",
				'items_per_page' => $num_per_page,
				'auto_hide' => true
		));

		$offset = $pagination->sql_offset;

		$incidents = ORM::factory('incident')
		         ->orderby('incident_dateadd','desc')
		         ->find_all($num_per_page,$offset);

		$this->template->content->pagination = $pagination->create_links();
		$this->template->content->incidents = $incidents;
			
	}
	
	
	function create()
	{
		$this->template->content = new View('admin/categories_create');
		$this->template->content->title = 'Categories';
		
		// setup and initialize form field names
		$form = array
	    (
	        'incident_title'      => '',
	        'incident_description'    => '',
	        'incident_date'  => '',
	        'incident_time'      => '',
	    );
	    
		
	}
}