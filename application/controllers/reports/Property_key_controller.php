<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_key_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Property_model','Bin_liner_setting_model']);
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	public function pdf()
	{
		$this->load->library('Properties_keys_pdf');

		$pdf = new Properties_keys_pdf();

		$pdf->set_data(new stdClass());

		$pdf->display_output();
	}

}