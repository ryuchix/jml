<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_fuel extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Vehicle_model', 
				'Vehicle_fuel_model',
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function lists($vehicle_id)
	{
		$this->set_data('vehicle_id', $vehicle_id);
		$this->set_data( 'records', $this->Vehicle_fuel_model->getWhere(['vehicle_id' => $vehicle_id]) );
		$this->load->view('vehicle_fuels/lists', $this->get_data());
	}

	function save($vehicle_id, $id=false){

		$record = new Vehicle_fuel_model();
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
				$record->date = db_date($this->input->post('date'));

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name']."/lists/$vehicle_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( $this->data['class_name']."/lists/$vehicle_id" ) );
				}
			}
		}
		
		$this->load->view('vehicle_fuels/form',$this->get_data());
	}

	function validate_form($id)
	{
       	// $this->form_validation->set_rules('data[vehicle_id]','Vehicle','required');
       	$this->form_validation->set_rules('date','Date','required');
       	$this->form_validation->set_rules('data[odometer]','Odometer','required');
       	$this->form_validation->set_rules('data[cost]','Cost','required|numeric');
       	$this->form_validation->set_rules('data[volume]','Volume','required|numeric');
	}

}