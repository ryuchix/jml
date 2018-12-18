<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MY_Controller
{
	private $validation_state = array();
	private $validation_message = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('Service_model');
		$this->set_data('active_menu', 'services');
	}


	function index($disable = false, $modified_item_id = 0)
	{
        $this->redirectIfNotAllowed('view-service');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data( 'inactive_records', $this->Service_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Service_model->getWhere(array('active'=>1)) );
		$this->set_data('sub_menu', 'view_services');
		$this->load->view('services/lists', $this->get_data());
	}

	function save($id=false)
    {
        $this->redirectIfNotAllowed( $id? 'edit-service': 'add-service', 'services');

		$this->set_data('sub_menu', 'add_service');
		$record = new Service_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		if ($id) {
           		$this->form_validation->set_rules('data[name]','Service Name','required|callback_custom_service_name_check['.$id.']');
       		}

			if ( $this->form_validation->run('add_service') == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->active = $id ? $record->active : 1;

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'services/' ) );
				}else{
					set_flash_message(2, "No changes made.!");
				}

			}
		}
		$this->load->view('services/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
        $this->redirectIfNotAllowed('change-service-status', 'services');

		$record = new Service_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Bin Type status changed to active');
			redirect( site_url( 'services/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Bin Type status changed to inactive');
			redirect( site_url( 'services/index/1/'.$id ) );
		}
	}

    public function custom_service_name_check($name,$id){
        $this->db->where('name',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('service');
        if($users->row()){
            $this->form_validation->set_message('custom_service_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    function upload_file($id=false)
    {
    	$config['upload_path']          = './uploads/services';
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
		        $record = new Service_model();
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
    	$file = './uploads/services/'.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax()
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$bin_type = new Service_model();
    		$bin_type->load($_POST['rec']);
    		$bin_type->image = '';
    		$bin_type->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($_POST['file_name']) ) );
    	}
    }


    /******************************************************************
    * Ajax Services For Services modules
    ****************************************************************/

    function get_service_by_id()
    {
    	if (isset($_POST['service_id'])) {
    		$service = new Service_model();
    		$service->load($_POST['service_id']);
    		echo json_encode(array('status'=>true, 'service'=>$service));
    	}else{
    		echo json_encode(array('status'=>false,'message'=>'direct link not permitted!'));
    	}
    }


}