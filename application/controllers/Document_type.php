<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_type extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Document_type_model');
		$this->set_data('active_menu', 'document_type');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-document-type');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_document_type');
		
		$this->set_data( 'inactive_records', $this->Document_type_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Document_type_model->getWhere(array('active'=>1)) );
		$this->load->view('document_types/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-document-type': 'add-document-type');
		$this->set_data('sub_menu', 'add_document_type');
		$record = new Document_type_model();
		if ($id) {
			$record->load($id);
			if (!$record->editable) {
				set_flash_message(2, "There is no previleges to edit default item");
				redirect( site_url( 'document_type/' ) );
			}
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		if ($id) {
       			$this->form_validation->set_rules('data[type]','Document Type','required|callback_custom_document_type_check['.$id.']');
       		}

			if ( $this->form_validation->run('add_document_type') == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'document_type/' ) );
				}

			}
		}
		$this->load->view('document_types/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-document-type-status');
		$record = new Document_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Document Type status changed to active');
			redirect( site_url( 'document_type/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Document Type status changed to inactive');
			redirect( site_url( 'document_type/index/1/'.$id ) );
		}
	}

    public function custom_document_type_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('document_type');
        if($users->row()){
            $this->form_validation->set_message('custom_document_type_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}