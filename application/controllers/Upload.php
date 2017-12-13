<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
	private $validation_state = array();
	private $validation_message = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('Service_model');
	}


	public function upload_test() {
        $this->load->helper(array('form', 'url'));

        if (isset($_FILES['resume']['name'])) {
            $config = array();
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|word';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('resume')) {
                $error = $this->upload->display_errors();
                echo "<pre>";
                echo print_r($error);
                echo "</pre>";
            } else {
                echo "<pre>";
                echo print_r($this->upload->data());
                echo print_r($_FILES);
                echo "</pre>";
            }
        }
		?>
        <?php echo form_open_multipart('upload/upload_test'); ?>

        <input type="file" name="resume" size="20" />

        <br /><br />

        <input type="submit" value="upload" />

        </form>
        
        <?php 
    }


}