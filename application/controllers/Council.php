<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Council extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Council_model'));
		$this->set_data('active_menu', 'council');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id=0)
	{
		$this->redirectIfNotAllowed('view-council');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		$this->set_data( 'sub_menu', 'view_council');
		$this->set_data( 'records', $this->Council_model->getWhere( array( 'active' => 1 ) ) );
    	$this->set_data( 'inactive_records', $this->Council_model->getWhere( array( 'active' => 0 ) ) );
		$this->load->view($this->data['class_name'].'s/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-council': 'add-council', 'council');
		$record = new Council_model();
		if ($id) {
			$this->set_data('sub_menu', 'add_supplier');
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			$this->set_conditional_validation_roles($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) 
				{
					$record->{$field} = is_array($value)? json_encode($value): $value;
				}

				$record->active = $id? $record->active: 1;
				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'] ) );
				}
			}
		}
		$this->load->view('councils/form',$this->get_data());
	}

	function set_conditional_validation_roles($id)
	{
		if ($id) {
           	$this->form_validation->set_rules('data[name]','Council name','required|callback_custom_name_check['.$id.']');
           	$this->form_validation->set_rules('data[email]','Email','required|callback_custom_email_check['.$id.']');
   		}else{
	    	$this->form_validation->set_rules('data[name]','Council name','required|is_unique[council.name]|max_length[255]');
    		$this->form_validation->set_rules('data[email]','Email','required|valid_email|is_unique[council.email]|max_length[255]');
   		}
	    $this->form_validation->set_rules('data[phone]','Phone number','required|max_length[255]');
    	$this->form_validation->set_rules('data[address]','Address','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_state]','State','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_suburb]','Suburb','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_post_code]','Suburb','required');
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-council-status');
		$record = new Council_model();
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
        $users = $this->db->get('council');
        if($users->row()){
            $this->form_validation->set_message('custom_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    public function custom_email_check($email,$id){
        $this->db->where('email',$email);
        $this->db->where('id !=',$id);
        $users = $this->db->get($this->data['class_name']);
        if($users->row()){
            $this->form_validation->set_message('custom_email_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

	function map($id){
		$record = new Council_model();
		$record->load($id);
		$this->set_data('record', $record);
		$this->load->view('clients/map', $this->get_data());
	}

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8