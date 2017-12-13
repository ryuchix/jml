<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_uploader extends MY_Controller
{
	private $base_folder = './uploads/';
	private $sub_folder = '';

	function __construct()
	{
		parent::__construct();
    	$this->sub_folder = isset($_POST['folder'])? $_POST['folder'].'/':'';
	}

    function image($id=false)
    {
    	$config['upload_path'] = $this->base_folder.$this->sub_folder;
        $config['allowed_types'] = 'gif|jpg|png|tif';

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
            if ( $id && isset($_POST['model']) ) {
		        $model = ucfirst($_POST['model']).'_model';
				$this->load->model($model);
	    		$record = new $model;
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
    	$file = $this->base_folder.$this->sub_folder.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax()
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$model = ucfirst($_POST['model']).'_model';
			$this->load->model($model);
    		$record = new $model;
    		$record->load($_POST['rec']);
    		$record->image = '';
    		$record->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($_POST['file_name']) ) );
    	}

    }

}