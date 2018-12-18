<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_links extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Vehicle_model',
			'Vehicle_finance_link_model'
		));
		$this->set_data('active_menu', 'vehicle');
		$this->set_data('class_name', strtolower(get_class($this)));
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
		    		
		    		$this->form_validation->set_rules("links[$index][url]",'Url','required');

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

	function save($vehicle_id, $id=false){

		$record = new vehicle_model();

		$record->load($vehicle_id);

		$this->set_data('record', $record);

		$this->load->library('form_validation');

		if( !isset($_POST['submit']) ){

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

		// $record->finance_start_date = $this->input->post('finance_start_date')? db_date($this->input->post('finance_start_date')):null;

		$this->db->trans_start();

		$id = $id? $id: $record->save();

		$this->db->simple_query("DELETE FROM vehicle_finance_links WHERE vehicle_id = $id");

		$link_queries = [];
		
		foreach ($this->input->post('links') as $index => $link) {
		
			$link_queries[] = [
		
				'vehicle_id' => $id,
		
				'name' => $link['name'],

				'url' => $link['url'],
		
				'created_by' => $this->session->userdata('user_id'),
		
			];
		
		}

		$this->db->insert_batch('vehicle_finance_links', $link_queries);

		$this->db->trans_complete();

		set_flash_message(0, "Record Submitted Successfully!");

		redirect( site_url( "vehicle/index/$vehicle_id" ) );

	}

	function draft(){

		$record = new Vehicle_finance_link_model();
		$record->name = '';
		$record->url = '';
		$record->vehicle_id = 0;
		
		$record->created_by = $this->session->userdata('user_id');

		echo $record->save();

	}
	

	function delete(){

		if ($this->input->post('pk')) {

			$record = new Vehicle_finance_link_model();

			$record->load($this->input->post('pk'));
			
			echo $record->delete();
			
		}

	}

}