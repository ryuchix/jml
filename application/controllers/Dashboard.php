<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('is_client'))
		{
			redirect('clients/dashboard');
		}

		$this->load->model(array( 
			'Client_model', 
			'Supplier_model', 
			'Property_model', 
			'Complain_model',
			'Quote_model',
			'Equipment_model',
			'User_model',
			'Vehicle_model',
			'File_model',
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

		$this->set_data('count_consumable_open_request', $this->db->select('id')
					->from('consumable_request')
                    ->where('status', STATUS_OPEN)
                    ->or_where('status', STATUS_AWAITING_FOR_APPROVAL)
				->count_all_results());

		$this->set_data('count_memos', $this->File_model->count_where([ 'type' => 'memo', 'active' => '1' ]));
		$this->set_data('count_files', $this->File_model->count_where([ 'type' => 'staff file', 'active' => '1' ]));
		$this->set_data('count_tutorial', $this->File_model->count_where([ 'type' => 'tutorial', 'active' => '1' ]));

		$this->set_data('regoes', $this->Dashboard_vehicle_information_model->get());
		$this->set_data('equipments', $this->Dashboard_equipment_information_model->get());

		$this->load->view('dashboard/index', $this->get_data());
	}
}


/* 

Yahoo App for Wheather
App ID
wgkSWC6o
Client ID (Consumer Key)
dj0yJmk9c0R6MWYyQ2tpWGV5JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PWUz
Client Secret (Consumer Secret)
c380214c733e148fc8226dd9e12d9639bd3b301b


*/