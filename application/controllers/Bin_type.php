<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bin_type extends MY_Controller
{
	private $validation_state = array();
	private $validation_message = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('Bin_type_model');
		$this->set_data('active_menu', 'bin_type');
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-bin-type');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_types');
		
		$this->set_data( 'inactive_records', $this->Bin_type_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Bin_type_model->getWhere(array('active'=>1)) );
		$this->load->view('bin_types/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-bin-type': 'add-bin-type', 'bin_type');

		$this->set_data('sub_menu', 'add_bin_type');
		$record = new Bin_type_model();
		if ($id) {
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		if ($id) {
       			$this->form_validation->set_rules('data[type]','Bin Type','required|callback_custom_bin_type_check['.$id.']');
       		}

			if ( $this->form_validation->run('add_bin_type') == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->active = $id ? $record->active : 1;

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'bin_type/' ) );
				}

			}
		}
		$this->load->view('bin_types/form',$this->get_data());
	}

	function edit($id){
		$this->load->library('form_validation');
		$record = new Service_model();
		$record->load($id);
		$this->set_data('record',$record);

		if (isset($_POST['submit'])) {
           	$this->form_validation->set_rules('data[name]','Service Name','required|callback_custom_service_name_check['.$id.']');
           	if ($this->form_validation->run() === TRUE ) {
           		
				$record->name 		 = $this->input->post('data[name]');
				$record->description = $this->input->post('data[description]');
				$record->updated_by  = $this->session->userdata('user_id');
				if ($record->save()) {
					set_flash_message(0, 'Record Submitted Successfully');
					redirect( site_url( 'services' ));
				}else{
					set_flash_message(2, "No changes made.");
				}

           	}
		}
		$this->load->view('services/edit', $this->get_data());

	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-bin-type-status', 'bin_type');
		$record = new Bin_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Bin Type status changed to active');
			redirect( site_url( 'bin_type/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Bin Type status changed to inactive');
			redirect( site_url( 'bin_type/index/1/'.$id ) );
		}
	}

    public function custom_bin_type_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('bin_type');
        if($users->row()){
            $this->form_validation->set_message('custom_bin_type_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    function upload_file($id=false)
    {
    	$config['upload_path']          = './uploads/bin_types';
        $config['allowed_types']        = 'gif|jpg|png|tif';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
			$s = json_encode($error);
            echo $s;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

	        if ( isset($_POST['old_image']) && !empty($_POST['old_image'])) {
	        	$this->delete_uploaded_file($_POST['old_image']);
	        }

            if ($id) {
		        $record = new Bin_type_model();
		        $record->load($id);
		        if ($record->image) {
		        	$this->delete_uploaded_file($record->image);
		        }
		        $record->image = $data['upload_data']['file_name'];
		        $record->save();
            }
            $s = json_encode($data['upload_data']);
            echo $s;
        }
    }

    function delete_uploaded_file($filename)
    {
    	$file = './uploads/bin_types/'.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax()
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$bin_type = new Bin_type_model();
    		$bin_type->load($_POST['rec']);
    		$bin_type->image = '';
    		$bin_type->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($_POST['file_name']) ) );
    	}

    }

}