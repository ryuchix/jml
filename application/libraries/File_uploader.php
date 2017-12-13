<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_uploader
{
	protected $CI;
	protected $folder = "uploads/";
	protected $sub_folder = '';
	protected $field = 'image';
	protected $model;
	protected $file_type;
	protected $data;
	protected $errors;

	function __construct($params)
	{
		$this->CI =& get_instance();

		$this->field = isset($params['field'])? $params['field']:'';
		$this->model = isset($params['model'])? $params['model']:'';
		$this->sub_folder = isset($params['sub_folder'])? $params['sub_folder']:'';
		$this->file_type = isset($params['file_type'])? $params['file_type']:'jpg|png';
	}

	function upload($record_id)
	{
		$config['upload_path'] = './'.$this->folder.$this->sub_folder;

    	if ($this->file_type) {
        	$config['allowed_types'] = $this->file_type;
    	}else{
    		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    		$not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
    		if ( in_array($ext, $not_allowed_types) ) {
    			$config['allowed_types'] = $this->file_type;
    		}else{
    			$config['allowed_types'] = $ext;
    		}
    	}

        $this->CI->load->library('upload', $config);

        if ( ! $this->CI->upload->do_upload('file') )
        {
            $this->errors = $this->CI->upload->display_errors();
            return false;
        }
        else
        {
            $this->data = array('upload_data' => $this->CI->upload->data());

	        if ( isset($_POST['old_image']) && !empty($_POST['old_image'])) {
	        	$this->delete_uploaded_file($_POST['old_image']);
	        }

	        if ($this->model) {
	        	$this->CI->load->model($this->model);
	            if ( $record_id ) {
	            	$model = $this->model;
			        $record = new $model();
			        $record->load($record_id);
			        if ($record->{$this->field}) {
			        	$this->delete_uploaded_file($record->{$this->field});
			        }
			        $record->{$this->field} = $this->data['upload_data']['file_name'];
			        $record->save();
	            }
	        }
            return true;
        }
	}

    function delete_uploaded_file($filename)
    {
    	$file = './'.$this->folder.$this->sub_folder.'/'.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax()
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$model = $this->model;
			$this->CI->load->model($model);
    		$record = new $model;
    		$record->load($_POST['rec']);
    		$record->{$this->field} = '';
    		$record->save();
    	}
    	if (isset($_POST['file_name'])) {
    		return json_encode( array('status' => $this->delete_uploaded_file($_POST['file_name']) ) );
    	}else{
    		return json_encode( array('error'=>true) );
    	}

    }


	/******************************* Setters And Getters *******************************/
	function getError()
	{
		return $this->errors;
	}
	
	function getData()
	{
		return $this->data;
	}

}


 ?>