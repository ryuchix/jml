<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array( 
			'Client_model', 
			'Supplier_model', 
			'Property_model', 
			'Complain_model',
			'Quote_model',
			'Equipment_model',
			'User_model',
			'Vehicle_model',
			'Consumable_request_model',
			'Dashboard_vehicle_information_model',
			'Dashboard_equipment_information_model',
		));
	}

	public function index()
	{
		// $this->set_data('count_all_client', $this->Client_model->get_count(0));
		// $this->set_data('count_all_prospect', $this->Client_model->get_count(1));
		// $this->set_data('count_all_supplier', $this->Supplier_model->get_count());
		// $this->set_data('count_all_property', $this->Property_model->get_count());
		$this->set_data('count_all_equipment', $this->Equipment_model->get_count());
		$this->set_data('count_open_or_assigned_complaints', $this->Complain_model->count_open_or_assigned());
		// $this->set_data('count_total_complaints', $this->Complain_model->count());
		// $this->set_data('count_pending_quotes', $this->Quote_model->count_where(['status'=>STATUS_PENDING]));
		$this->set_data('bday_users', $this->User_model->get_birthday_users());
		$this->set_data('count_all_vehicle', $this->Vehicle_model->count());
		$this->set_data('count_consumable_open_request', $this->Consumable_request_model->count_where(['status'=>STATUS_OPEN]));

		$this->set_data('regoes', $this->Dashboard_vehicle_information_model->get());
		$this->set_data('equipments', $this->Dashboard_equipment_information_model->get());

		$this->load->view('dashboard/index', $this->get_data());
	}
}
