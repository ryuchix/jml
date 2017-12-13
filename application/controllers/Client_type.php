<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_type extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Client_type_model');
		$this->set_data('active_menu', 'client_type');
	}

	function index($disable = false, $modified_item_id=0)
	{
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		$this->set_data( 'sub_menu', 'view_client_type');
		$this->set_data( 'records', $this->Client_type_model->getWhere( array( 'active' => 1 ) ) );
    	$this->set_data( 'inactive_records', $this->Client_type_model->getWhere( array( 'active' => 0 ) ) );

		$this->load->view('client_types/lists', $this->get_data());
	}

	function add(){

		$this->set_data('sub_menu', 'add_client_types');
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

			if ( $this->form_validation->run('add_client_type') == TRUE ) {
				$record = new Client_type_model();
				$record->type 		  = $this->input->post('data[type]');
				$record->description  = $this->input->post('data[description]');
				$record->active 	  = 1;
				$record->added_by 	  = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'client_type' ) );
				}

			}
		}

		$this->load->view('client_types/add', $this->get_data());
	}

	function edit($id){
		$this->load->library('form_validation');
		$record = new Client_type_model();
		$record->load($id);
		$this->set_data('record', $record);

		if (isset($_POST['submit'])) {
           	$this->form_validation->set_rules('data[type]','Client type name','required|callback_custom_client_type_name_check['.$id.']');
           	if ($this->form_validation->run() === TRUE ) {
           		
				$record->type 		 = $this->input->post('data[type]');
				$record->description = $this->input->post('data[description]');
				$record->updated_by  = $this->session->userdata('user_id');
				if ($record->save()) {
					set_flash_message(0, 'Record Submitted Successfully');
					redirect( site_url( 'client_type' ));
				}else{
					set_flash_message(2, 'No changes made');
				}

           	}
		}
		$this->load->view('client_types/edit', $this->get_data());
	}

	// function delete($id){
	// 	$record = new Client_model();
	// 	$record->load($id);
	// 	if ($record->delete()) {
	// 		set_flash_message(0, 'Record Successfully Deleted');
	// 		redirect( site_url( 'client_type' ) );
	// 	}else{
	// 		set_flash_message(1, 'There may some problem while deleting record');
	// 		redirect( site_url( 'client_type' ) );
	// 	}
	// }

	function activation($id, $boolean=false)
	{
		$record = new Client_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Client type status changed to active');
			redirect( site_url( 'client_type/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Client type status changed to inactive');
			redirect( site_url( 'client_type/index/1/'.$id ) );
		}
	}


    public function custom_client_type_name_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('client_type');
        if($users->row()){
            $this->form_validation->set_message('custom_client_type_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}