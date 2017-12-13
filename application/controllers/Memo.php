<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Memo_model');
		$this->set_data('active_menu', 'memo');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_memo');
		
		$this->set_data( 'inactive_records', $this->Memo_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Memo_model->getWhere(array('active'=>1)) );
		$this->load->view('memos/lists', $this->get_data());
	}

	function save($id=false){
		$this->set_data('sub_menu', 'add_memo');
		$this->set_data('expected_memo_number', $this->Memo_model->max());
		$record = new Memo_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
       		
       		$this->form_validation->set_rules('data[title]','Title','required');

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'memo/' ) );
				}else{
					set_flash_message(1, "No changes made!");
				}

			}
		}
		$this->load->view('memos/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$record = new Memo_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Document Type status changed to active');
			redirect( site_url( 'memo/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Document Type status changed to inactive');
			redirect( site_url( 'memo/index/1/'.$id ) );
		}
	}

    /*************************************** FILES *****************************************/

    function upload_complain_file($id=0)
    {
        // upload_file( $folder, $file_types, $model )
        $this->upload_file('memos', false, 'Memo_model', $id);
    }

    function upload_file($folder, $file_type=false, $model, $record_id)
    {
    	$config['upload_path'] = './uploads/'.$folder;

    	if ($file_type) {
        	$config['allowed_types'] = $file_type;
    	}else{
    		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    		$not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
    		if ( in_array($ext, $not_allowed_types) ) {
    			$config['allowed_types'] = 'gif|jpg|png|tif|doc|docx|word|pdf';
    		}else{
    			$config['allowed_types'] = $ext;
    		}
    	}

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
	        	$this->delete_uploaded_file($folder, $_POST['old_image']);
	        }

            if ( $record_id ) {
		        $record = new $model();
		        $record->load($record_id);
		        if ($record->file) {
		        	$this->delete_uploaded_file($folder, $record->file);
		        }
		        $record->file = $data['upload_data']['file_name'];
		        $record->save();
            }
            $s = json_encode($data['upload_data']);
            echo $s;
        }
    }

    function delete_uploaded_file($folder, $filename)
    {
    	$file = './uploads/'.$folder.'/'.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax($folder, $model)
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$model = $model.'_model';
    		$record = new $model();
    		$record->load($_POST['rec']);
    		$record->file = '';
    		$record->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($folder, $_POST['file_name']) ) );
    	}
    }

}