<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_type extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Lead_type_model');
		$this->set_data('active_menu', 'document_type');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_document_type');
		
		$this->set_data( 'inactive_records', $this->Lead_type_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Lead_type_model->getWhere(array('active'=>1)) );
		$this->load->view('lead_types/lists', $this->get_data());
	}

	function save($id=false){
		$this->set_data('sub_menu', 'add_lead_type');
		$record = new Lead_type_model();
		if ($id) {
			$record->load($id);
			if (!$record->editable) {
				set_flash_message(2, "There is no previleges to edit default item");
				redirect( site_url( 'lead_type/' ) );
			}
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		if ($id) {
       			$this->form_validation->set_rules('data[type]','Lead Type','required|callback_custom_document_type_check['.$id.']');
       		}else{
       			$this->form_validation->set_rules('data[type]','Lead Type','required|is_unique[lead_type.type]');
       		}

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'lead_type/' ) );
				}

			}
		}
		$this->load->view('lead_types/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$record = new Lead_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Lead Type status changed to active');
			redirect( site_url( 'lead_type/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Lead Type status changed to inactive');
			redirect( site_url( 'lead_type/index/1/'.$id ) );
		}
	}

    public function custom_document_type_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('lead_type');
        if($users->row()){
            $this->form_validation->set_message('custom_document_type_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}