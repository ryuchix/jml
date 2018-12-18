<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportsController extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id=0, $prospect=0)
	{
		$this->load->view('reports/index', $this->get_data());
	}


}