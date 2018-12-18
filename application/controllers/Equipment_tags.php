<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment_tags extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		
        $this->load->model([
			'Equipment_model',
			'Equipment_tags_model',
			'Supplier_model'
		]);

		$this->set_data('active_menu', 'equipments');
		
        $this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($equipment_id, $disable = false, $modified_item_id = 0)
	{
		$this->set_data('equipment_id', $equipment_id);

		$this->set_data('sub_menu', 'view_equipment');

		$this->set_data( 'records', $this->Equipment_tags_model->get_lists_by_equipment_id($equipment_id) );

		$this->load->view('equipment_tags/lists', $this->get_data());
	}

	function save($equipment_id, $id=false)
    {
		$this->set_data('sub_menu', 'add_equipment_tag');

		$this->set_data('equipment_id', $equipment_id);

		$record = new Equipment_tags_model();

		if ($id) { $record->load($id); }

		$this->set_data('record', $record);

		$this->set_data('suppliers', $this->Supplier_model->get_dropdown_lists());
		
		$this->load->library('form_validation');

		if( ! isset($_POST['submit']) )
        {
            $this->load->view('equipment_tags/form', $this->get_data());
            return;
		}
        
        $this->validate_fields($id);

        if ( $this->form_validation->run() == FALSE ) 
        {
            $this->load->view('equipment_tags/form', $this->get_data());
            return;
        }

        foreach ($this->input->post('data') as $field => $value) {
            $record->{$field}   = $value;
        }

        $record->booked_date = db_date($this->input->post('booked_date'));
        
        $record->next_service_date = $this->input->post('next_service_date')? 
                                        db_date($this->input->post('next_service_date')):null;
        $record->save();

        set_flash_message(0, "Record Submitted Successfully!");

        redirect( site_url( "equipment_tags/index/$record->equipment_id" ) );

		$this->load->view('equipment_tags/form', $this->get_data());
	}

	function validate_fields($id)
	{
		if ($id) {  }
   		$this->form_validation->set_rules('data[equipment_id]','Equipment','required');
   		$this->form_validation->set_rules('booked_date','Booked Date','required');
   		$this->form_validation->set_rules('data[cost]','Cost','required|numeric');
   		$this->form_validation->set_rules('data[supplier_id]','Supplier','required');
	}


	/************************************************ File Upload ************************************************/

    function upload_equipment_tag_file($id=0)
    {
        $this->upload_file('equipment_tags', false, 'Equipment_tags_model', $id);
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

        if ( ! $this->upload->do_upload('file') )
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