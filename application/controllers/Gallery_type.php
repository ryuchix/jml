<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_type extends MY_Controller
{
	private $validation_state = array();
	private $validation_message = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_type_model');
		$this->set_data('active_menu', 'gallery_type');
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-gallery-type');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_gallery_types');
		
		$this->set_data( 'inactive_records', $this->Gallery_type_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Gallery_type_model->getWhere(array('active'=>1)) );
		$this->load->view('gallery_types/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-gallery-type': 'add-gallery-type', 'gallery_type');

		$this->set_data('sub_menu', 'add_gallery_type');
		$record = new Gallery_type_model();
		if ($id) {
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		if ($id)
       			$this->form_validation->set_rules('data[type]','Gallery Type','required|callback_custom_bin_type_check['.$id.']');
       		else
       			$this->form_validation->set_rules('data[type]','Gallery Type','required|is_unique[gallery_type.type]');

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->active = $id ? $record->active : 1;

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'gallery_type/' ) );
				}

			}
		}
		$this->load->view('gallery_types/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-gallery-type-status','gallery_type');
		$record = new Gallery_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Gallery Type status changed to active');
			redirect( site_url( 'gallery_type/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Gallery Type status changed to inactive');
			redirect( site_url( 'gallery_type/index/1/'.$id ) );
		}
	}

    public function custom_bin_type_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('gallery_type');
        if($users->row()){
            $this->form_validation->set_message('custom_bin_type_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}