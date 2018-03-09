<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_rego extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Vehicle_model', 
				'Vehicle_rego_model',
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($vehicle_id)
	{
		$this->set_data('vehicle_id', $vehicle_id);
		$this->set_data( 'records', $this->Vehicle_rego_model->getWhere(array('vehicle_id'=>$vehicle_id)) );
		$this->load->view('vehicle_regos/lists', $this->get_data());
	}

	function save($vehicle_id, $id=false){

		$record = new Vehicle_rego_model();
		$this->set_data( 'vehicle_id', $vehicle_id );
		$vehicle = new vehicle_model();
		$vehicle->load($vehicle_id);

		if ($id) { $record->load($id); }else{  $record->vehicle_id = $vehicle_id; }

		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			$this->validate_form($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) { $record->{$field} = $value; }
				$record->expiry_date = db_date($this->input->post('expiry_date'));
				$record->due_date = db_date($this->input->post('due_date'));
				$record->paid_date = $this->input->post('paid_date')? db_date($this->input->post('paid_date')) : null;

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name']."/index/$vehicle_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( $this->data['class_name']."/index/$vehicle_id" ) );
				}
			}
		}
		$this->load->view('vehicle_regos/form',$this->get_data());
	}

	function delete($vehicle_id, $id){

		$record = new Vehicle_rego_model();
		$record->load($id);

		if ( $record->save() ) {
			set_flash_message(0, "Record Deleted Successfully!");
			redirect( site_url( "$this->data['class_name']/index/$vehicle_id" ) );
		}

	}

	function validate_form($id)
	{
       	// $this->form_validation->set_rules('data[vehicle_id]','Vehicle','required');
       	$this->form_validation->set_rules('data[rate]','Rate','required|numeric');
       	$this->form_validation->set_rules('data[status]','Status','required');
       	$this->form_validation->set_rules('due_date','Payment Due Before','required');
       	$this->form_validation->set_rules('expiry_date','Expiry Date','required');
       	if ($this->input->post('data[status]') && $this->input->post('data[status]') == STATUS_PAID) {
       		$this->form_validation->set_rules('paid_date','Expiry Date','required');
       		$this->form_validation->set_rules('data[receipt_no]','Receipt no.','required');
       	}
	}

    /**************************************** Services **************************************/


    function upload($id='')
    {
    	$config['model'] 		= 'Vehicle_rego_model';
    	$config['field'] 		= 'file';
    	$config['sub_folder'] 	= 'vehicle_regos';
    	$config['file_type'] 	= false;

    	$this->load->library("File_uploader", $config);

    	if ($this->file_uploader->upload($id)) {
    		echo json_encode($this->file_uploader->getData()['upload_data']);
    	}else{
    		echo json_encode($this->file_uploader->getError());
    	}
    }

    function delete_file()
    {
    	$config['model'] 		= 'Vehicle_rego_model';
    	$config['field'] 		= 'file';
    	$config['sub_folder'] 	= 'vehicle_regos';

    	$this->load->library("File_uploader", $config);

    	echo $this->file_uploader->delete_via_ajax();
    }

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8