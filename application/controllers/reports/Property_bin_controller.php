<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_bin_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	public function pdf()
	{
		$this->load->library('Properties_bins_pdf');

		$pdf = new Properties_bins_pdf();

		$pdf->set_data(new stdClass());

		$pdf->display_output();
	}

}