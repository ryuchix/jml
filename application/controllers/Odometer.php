<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Odometer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Vehicle_model', 
				'Vehicle_odometer_model',
				'User_model',
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function lists($vehicle_id)
	{
		$this->set_data('vehicle_id', $vehicle_id);
		$this->set_data( 'records', $this->Vehicle_odometer_model->get_list_by_vehicle_id($vehicle_id) );
		$this->load->view('vehicle_odometers/lists', $this->get_data());
	}

	function save($vehicle_id, $id=false){

		$record = new Vehicle_odometer_model();
		$this->set_data( 'vehicle_id', $vehicle_id );
		$vehicle = new vehicle_model();
		$vehicle->load($vehicle_id);

		$this->set_data( 'users', $this->User_model->get_dropdown_lists() );
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
		$this->load->view('vehicle_odometers/form',$this->get_data());
	}

	function validate_form($id)
	{
       	// $this->form_validation->set_rules('data[vehicle_id]','Vehicle','required');
       	$this->form_validation->set_rules('date','Date','required');
       	$this->form_validation->set_rules('data[start_time]','Start Time','required');
       	$this->form_validation->set_rules('data[finish_time]','Finish Time','required');
       	$this->form_validation->set_rules('data[odometer_start]','Odometer Start','required|numeric');
       	$this->form_validation->set_rules('data[odometer_finish]','Odometer Finish','required|numeric|callback_custom_odometer_finish_time');
       	$this->form_validation->set_rules('data[purpose_of_trip]','Purpose of trip','required');
       	$this->form_validation->set_rules('data[driver]','Driver','required');
	}

    public function custom_odometer_finish_time($odometer_finish,$id){
        $odometer_finish = $odometer_finish;
        $odometer_start = $this->input->post('data[odometer_start]');
        if( $odometer_start > $odometer_finish ){
            $this->form_validation->set_message('custom_odometer_finish_time', 'The {field} must be greater than Odometer Start.');
            return false;
        }else{
            return true;
        }
    }

}