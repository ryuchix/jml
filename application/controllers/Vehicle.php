<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Vehicle_model',
			'User_model',
			'Vehicle_finance_link_model'
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-vehicle');

		$this->delete_draft_entries();

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		
		$this->set_data('sub_menu', 'view_vehicle');

		$this->set_data( 'inactive_records', $this->Vehicle_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Vehicle_model->getWhere(array('active'=>1)) );
		$this->load->view('vehicles/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id?'edit-vehicle':'add-vehicle');
		
		$this->load->library('form_validation');
		
		$this->delete_draft_entries();

		$this->set_data('sub_menu', 'add_vehicle');
		$this->set_data( 'users', $this->User_model->get_dropdown_lists() );

		$record = new Vehicle_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);

		if( isset($_POST['submit']) ){

			$this->validate_fields($id);

			if ( $this->form_validation->run() == TRUE ) {

				foreach ($this->input->post('data') as $field => $value) { $record->{$field} = $value; }
				$record->show_in_app = $this->input->post('show_in_app')?? 0;
				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'vehicle/' ) );
				}else{
					set_flash_message(1, "No changes made!");
					redirect( site_url( 'vehicle/' ) );
				}
			}
		}
		$this->load->view('vehicles/form',$this->get_data());
	}

	function validate_fields($id)
	{
		switch ($id) {
			case 'finance':
		    	$this->form_validation->set_rules('data[finance_status]','Status','required|max_length[255]');
		    	$this->form_validation->set_rules('data[finance_company]','Company','required|max_length[255]');
		    	$this->form_validation->set_rules('data[finance_amount]','Amount','required|numeric|max_length[255]');
		    	$this->form_validation->set_rules('data[finance_monthly_payment]','Monthly Payment','required|numeric');

		    	$this->form_validation->set_rules('data[finance_monthly_payment]','Monthly Payment','required|numeric');

		    	foreach ($this->input->post('links') as $index => $link) {
		    		$this->form_validation->set_rules("links[$index][name]",'Link Name','required');
		    		$this->form_validation->set_rules("links[$index][url]",'Url','required|valid_url');
		    	}

				break;

			case 'insurance':
		    	$this->form_validation->set_rules('data[insurance_company]','Insurance Company','required|max_length[255]');
		    	$this->form_validation->set_rules('data[insurance_number]','Insurance Number','required|max_length[255]');
		    	$this->form_validation->set_rules('insurance_date','Insurance Date','required|max_length[255]');
		    	$this->form_validation->set_rules('insurance_expiry_date','Expiry Date','required|max_length[255]');
		    	$this->form_validation->set_rules('data[insurance_monthly_payment]','Monthly Payment','required|max_length[255]');
				break;

			default:
		    	$this->form_validation->set_rules('data[license_plate]','License Plate','required|max_length[255]');
		    	$this->form_validation->set_rules('data[make]','Make','required|max_length[255]');
		    	$this->form_validation->set_rules('data[model]','Model','required|max_length[255]');
		    	$this->form_validation->set_rules('data[year]','Client Year','required|max_length[255]|numeric');
		    	$this->form_validation->set_rules('data[vin_no]','Vin no.','required|max_length[255]');
		    	$this->form_validation->set_rules('data[color]','Colour','required|max_length[255]');
		    	$this->form_validation->set_rules('data[gas_type]','Gasonline Type','required|max_length[255]');
		    	$this->form_validation->set_rules('data[garagge]','Garagge','required|max_length[255]');
		    	$this->form_validation->set_rules('data[assign_to]','Assign to','required|max_length[255]');
				break;
		}
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-vehicle-status');
		
		$record = new Vehicle_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) 
		{
			set_flash_message(0, 'Vehicle status changed to active');
			redirect( site_url( 'vehicle/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Vehicle status changed to inactive');
			redirect( site_url( 'vehicle/index/1/'.$id ) );
		}
	}

	function finance($id){

		$this->redirectIfNotAllowed('view-vehicle-finance');
		
		$record = new vehicle_model();

		$record->load($id);

		$this->set_data('record', $record);

		$this->set_data('links', $this->Vehicle_finance_link_model->getWhere(['vehicle_id' => $id, 'draft' => '0']));

		$this->load->library('form_validation');

		if( !isset($_POST['submit']) ){

			$this->delete_draft_entries();
			
			$this->load->view('vehicles/finance_form',$this->get_data());

			return;
		}
			
		$this->validate_fields("finance");
       		
		if ( $this->form_validation->run() == FALSE ) {

			$this->load->view('vehicles/finance_form',$this->get_data());

			return;

		}
				
		foreach ($this->input->post('data') as $field => $value) 
		{
			$record->{$field} = $value;
		}

		$record->finance_start_date = $this->input->post('finance_start_date')? db_date($this->input->post('finance_start_date')):null;

		$this->db->trans_start();

		$id = $id? $id: $record->save();

		$link_queries = [];
		
		foreach ($this->input->post('links') as $index => $link) {
		
			$item = new Vehicle_finance_link_model();

			$item->load($link['pk']);
			
			$item->vehicle_id = $id;
			
			$item->draft = 0;
			
			$item->name = $link['name'];
			
			$item->url = $link['url'];

			$item->save();
		
		}

		$this->db->trans_complete();

		set_flash_message(0, "Record Submitted Successfully!");

		redirect( site_url( "vehicle/index/$vehicle_id" ) );

	}

	function insurance($id){

		$this->redirectIfNotAllowed('view-vehicle-insurance');
		
		$record = new vehicle_model();
		$record->load($id);
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			$this->validate_fields("insurance");
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) { $record->{$field} = $value; }
				$record->insurance_date = db_date($this->input->post('insurance_date'));
				$record->insurance_expiry_date = db_date($this->input->post('insurance_expiry_date'));

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "vehicle/index/$vehicle_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( "vehicle/index/$vehicle_id" ) );
				}
			}
		}

		$this->load->view('vehicles/insurance_form',$this->get_data());
	}

	protected function delete_draft_entries()
	{
		$this->db->simple_query("DELETE FROM vehicle_finance_links WHERE draft = 1");
	}

    function upload($id='', $insurance_file=false)
    {
    	$config['model'] 		= 'Vehicle_model';
    	$config['field'] 		= $insurance_file? $insurance_file : 'image';
    	$config['sub_folder'] 	= 'vehicles';
    	$config['file_type'] 	= $insurance_file? false : 'jpg|png';

    	$this->load->library("File_uploader", $config);

    	if ($this->file_uploader->upload($id)) {
    		echo json_encode($this->file_uploader->getData()['upload_data']);
    	}else{
    		echo json_encode($this->file_uploader->getError());
    	}
    }

    function delete_file($insurance_file=false)
    {
    	$config['model'] 		= 'Vehicle_model';
    	$config['field'] 		= $insurance_file? $insurance_file : 'image';
    	$config['sub_folder'] 	= 'vehicles';

    	$this->load->library("File_uploader", $config);

    	echo $this->file_uploader->delete_via_ajax();
    }

}