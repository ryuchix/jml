<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bin_liner_management_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Property_model','Bin_liner_setting_model']);
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id=0, $prospect=0)
	{
		$this->set_data('properties', $this->Property_model->get_dropdown_lists_of_service('Bin Liners'));
		$this->set_data('sizes', $this->Bin_liner_setting_model->get_dropdown_lists());
		$this->load->view('reports/bin_liner_management/filters', $this->get_data());
	}

	public function pdf()
	{
		$this->load->library('Bin_liner_management_pdf');

		$pdf = new Bin_liner_management_pdf();

		$pdf->set_data(new stdClass());

		$pdf->display_output();
	}

}