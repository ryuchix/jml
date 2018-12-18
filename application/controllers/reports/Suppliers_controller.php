<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Supplier_model']);
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index()
	{
		$this->load->library('Supplier_pdf');

		$pdf = new Supplier_pdf();

		$pdf->display_output();
	}

}