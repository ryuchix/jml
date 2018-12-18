<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Council_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Council_model']);
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index()
	{
		$this->load->library('Council_pdf');

		$pdf = new Council_pdf();

		$pdf->display_output();
	}

}