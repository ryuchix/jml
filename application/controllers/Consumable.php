<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumable extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Consumable_model', 'Supplier_model'));
		$this->set_data('active_menu', 'consumable');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id=0)
	{
		$this->redirectIfNotAllowed('view-consumable');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		$this->set_data( 'sub_menu', 'view_consumable');

		$sql = "SELECT c.id, c.ref_code, c.name, c.description, c.active, s.name AS supplier, c.price, c.unit_per_box
			FROM consumable AS c
			JOIN supplier AS s ON s.id = c.supplier_id WHERE c.active = ";

		$this->set_data( 'records', $this->db->query($sql.'1')->result() );
    	$this->set_data( 'inactive_records', $this->db->query($sql.'0')->result() );
		$this->load->view('consumables/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-consumable':'add-consumable');
		$record = new Consumable_model();
		if ($id) {
			$this->set_data('sub_menu', 'add_consumable');
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');
		
		$this->set_data(
			'suppliers', 
			array_map(function($o){ 
					return $o->name; 
				}, $this->Supplier_model->getWhere(array('active'=>1))
			) // array_map
		); // set data

		if (!count($this->data['suppliers'])) {
			set_flash_message(1, "There is no Supplier listed please create one.");
			redirect( site_url( 'supplier/save' ) );
		}

		if( isset($_POST['submit']) ){
			
			$this->set_conditional_validation_roles($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} = $value;
				}
				$record->active = $id? $record->active: 1;
				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'].'/' ) );
				}
			}
		}
		$this->load->view($this->data['class_name'].'s/form',$this->get_data());
	}

	function set_conditional_validation_roles($id)
	{
		if ($id) {
           	$this->form_validation->set_rules('data[name]','Name','required|callback_custom_name_check['.$id.']');
   		}else{
	    	$this->form_validation->set_rules('data[name]','Name','required|is_unique[consumable.name]|max_length[255]');
   		}
    	$this->form_validation->set_rules('data[supplier_id]','Supplier','required');
	    $this->form_validation->set_rules('data[ref_code]','Reference Code','required|max_length[255]');
    	$this->form_validation->set_rules('data[description]','Description','required|max_length[255]');
    	$this->form_validation->set_rules('data[price]','Price','required|numeric');
    	$this->form_validation->set_rules('data[unit_per_box]','No of units per box','required|max_length[255]');
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-consumable-status');
		$record = new Consumable_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Supplier status changed to active');
			redirect( site_url( $this->data['class_name'].'/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Supplier status changed to inactive');
			redirect( site_url( $this->data['class_name'].'/index/1/'.$id ) );
		}
	}

    public function custom_name_check($name,$id){
        $this->db->where('name',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('consumable');
        if($users->row()){
            $this->form_validation->set_message('custom_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    function reqest($id)
    {
		// $this->redirectIfNotAllowed($id? 'edit-consumable-request':'add-consumable-request');
		$record = new Consumable_model();
		if ($id) {
			$this->set_data('sub_menu', 'add_consumable');
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');
		
		$this->set_data(
			'suppliers', 
			array_map(function($o){ 
					return $o->name; 
				}, $this->Supplier_model->getWhere(array('active'=>1))
			) // array_map
		); // set data

		if (!count($this->data['suppliers'])) {
			set_flash_message(1, "There is no Supplier listed please create one.");
			redirect( site_url( 'supplier/save' ) );
		}

		if( isset($_POST['submit']) ){
			
			$this->set_conditional_validation_roles($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} = $value;
				}
				$record->active = $id? $record->active: 1;
				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'].'/' ) );
				}
			}
		}
		$this->load->view($this->data['class_name'].'s/form',$this->get_data());
    }

    /*********************************** Consumables Services ***********************************/
    function get_consumable_service()
    {
    	if (isset($_POST['consumable_id'])) {
    		$record = new Consumable_model();
    		$record->load($_POST['consumable_id']);

    		echo json_encode($record);
    	}
    }

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8