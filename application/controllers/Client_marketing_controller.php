<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_marketing_controller extends MY_Controller
{
	protected $file_path = './uploads/client_marketing/';
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Client_model', 
				'Client_type_model', 
				'Contacts_model', 
				'Client_note_model', 
				'Client_file_model',
				'Client_marketing_log_model',
				'Property_model'
			));
		$this->set_data('active_menu', 'client');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'client';
	}

	function index($client_id)
	{
		$this->redirectIfNotAllowed('view-client-marketing');

		$client = new Client_model();
		$client->load($client_id);

		$client_type = new Client_type_model();
		$client_type->load($client->client_type);
		$client->client_type = $client_type;

		$this->set_data('client', $client);
		$this->set_data('contacts', $client->contacts());

		$logs = $this->Client_marketing_log_model->get_note_with_attachment($client_id);
		$this->set_data('logs', $logs);

		$this->load->view('clients/marketing/index', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-client':'add-client');
		$this->load->view('clients/form',$this->get_data());
	}

	function save_note($client_id, $log_id=0)
	{
		$note = new Client_marketing_log_model();

		if($log_id)
		{ 
			$note->load($log_id); 
		}

		if ( isset($_POST['submit']) ) 
		{
			if ( !empty($_FILES) && $_FILES['upl_files']['error'][0] != 4) 
			{ 
				$uploaded_files = $this->multiple_upload();

			}else{ 

				$uploaded_files = []; 

			}

			if ($this->is_uploaded($uploaded_files)) 
			{
				$this->db->trans_start();

				$note->note 	= $this->input->post('notes');

				$note->client_id 	= $client_id;

				if (!$log_id) 
				{
					$note->added_by = $this->session->userdata('user_id');
				}

				$inserted_id = $note->save();
				
				$log_id = $log_id? $log_id: $inserted_id;

				$this->db->trans_complete();

				$note->add_attachments($uploaded_files);

				if ($this->db->trans_status()) 
				{
					set_flash_message(0, 'Log has been Added.' );

					if($this->input->post('redirect'))
						redirect(site_url($this->input->post('redirect')));

					redirect( site_url( "clients-marketing/$client_id/logs" ) );
				}

			}else{

				set_flash_message(2, '<p>'. join('</p><p>', $this->upload_error) .'</p>' );

				redirect( site_url( "clients-marketing/$client_id/logs" ) );
			}

		}
	}
    
    public function multiple_upload()
	{
	    $this->load->library('upload');
	    $number_of_files_uploaded = count($_FILES['upl_files']['name']);
	    $files = array();
	    // Faking upload calls to $_FILE
	    for ($i = 0; $i < $number_of_files_uploaded; $i++) :
	      	$_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
	      	$_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
	      	$_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
	      	$_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
	      	$_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
	      	$config = array(
		        // 'file_name'     => '',
		        'allowed_types' => 'jpg|jpeg|png|gif',
		        // 'max_size'      => 3000,
		        'overwrite'     => FALSE,
		        'upload_path' => $this->file_path
	      	);
	      	$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
    		$not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
    		if ( in_array($ext, $not_allowed_types) ) {
    			$config['allowed_types'] = 'gif|jpg|png|tif|doc|docx|word|pdf';
    		}else{
    			$config['allowed_types'] = $ext;
    		}
	      	$this->upload->initialize($config);
	      	if ( ! $this->upload->do_upload() ) :
	      		$files[] = false;
	      		// x($this->upload->display_errors());
		        $error = array('error' => $this->upload->display_errors());
	      		$this->upload_error[] = $error['error'];
	    	  else :
	        	$data = $this->upload->data();
	      		$files[] = $data['file_name'];
	      	endif;
	    endfor;
	    return $files;
	}

	function is_uploaded($data)
	{
		$uploaded = true;
		foreach ($data as $file) {
			if (!$file) {
				$uploaded = false;
				break;
			}
		}
		return $uploaded;
	}

	function delete_attachment()
	{
		if (isset($_POST['file_id'])) {
			$record = new Job_note_attachments_model();
			$record->load($_POST['file_id']);

			$file = $this->file_path.'/'.$record->file;
			if (file_exists($file)) {
				unlink($file);
				$record->delete();
				echo json_encode(['status' => true]);
			}else{
				echo json_encode(['status' => false]);
			}
		}
	}

	function validateDate($date)
	{
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    return $d && $d->format('Y-m-d') === $date;
	}


}
