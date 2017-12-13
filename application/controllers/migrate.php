<?php 

/**
* DATABASE MIGRATION CLASS
*/
class Migrate extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->input->is_cli_request() == FALSE) {
			show_404();
		}

		$this->load->library('migration');
		$this->load->dbforge();
	}

	function latest()
	{
		$this->migration->latest();
		echo $this->migration->error_string() . PHP_EOL;
	}
}

 ?>