<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_services extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Vehicle_model', 
				'Vehicle_services_model',
				'Supplier_model',
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function lists($vehicle_id)
	{
		$this->redirectIfNotAllowed('view-vehicle-service');
		$this->set_data('vehicle_id', $vehicle_id);
		$this->set_data( 'records', $this->Vehicle_services_model->get_list_by_vehicle_id($vehicle_id) );
		$this->load->view('vehicle_services/lists', $this->get_data());
	}

	function save($vehicle_id, $id=false){

		$this->redirectIfNotAllowed($id?'edit-vehicle-service':'add-vehicle-service');
		
		$record = new Vehicle_services_model();
		$this->set_data( 'vehicle_id', $vehicle_id );
		$vehicle = new vehicle_model();
		$vehicle->load($vehicle_id);

		$this->set_data( 'suppliers', $this->Supplier_model->get_dropdown_lists() );
		if ($id) { $record->load($id); }else{  $record->vehicle_id = $vehicle_id; }

		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			$this->validate_form($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) { $record->{$field} = $value; }
				$record->date = db_date($this->input->post('date'));
				$record->next_service_date = $this->input->post('next_service_date')? db_date($this->input->post('next_service_date')):null;

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name']."/lists/$vehicle_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( $this->data['class_name']."/lists/$vehicle_id" ) );
				}
			}
		}
		$this->load->view('vehicle_services/form',$this->get_data());
	}

	function validate_form($id)
	{
       	// $this->form_validation->set_rules('data[vehicle_id]','Vehicle','required');
       	$this->form_validation->set_rules('date','Date','required');
       	$this->form_validation->set_rules('data[odometer]','Odometer','required');
       	$this->form_validation->set_rules('data[cost]','Cost','required|numeric');
       	$this->form_validation->set_rules('data[next_service_odo]','Next Service Odo','required');
       	$this->form_validation->set_rules('data[supplier_id]','Supplier','required');
	}

    /**************************************** Services **************************************/


    function upload($id='')
    {
    	$config['model'] 		= 'Vehicle_services_model';
    	$config['field'] 		= 'report';
    	$config['sub_folder'] 	= 'vehicle_services';
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
    	$config['model'] 		= 'Vehicle_services_model';
    	$config['field'] 		= 'report';
    	$config['sub_folder'] 	= 'vehicle_services';

    	$this->load->library("File_uploader", $config);

    	echo $this->file_uploader->delete_via_ajax();
    }

}