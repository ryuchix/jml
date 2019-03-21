<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaints extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Complain_model', 
			'User_model', 
			'Property_model',
			'Client_model',
			'Complain_file_model',
			'Document_type_model'
		));
		$this->set_data('active_menu', 'complain');
		$this->context = 'complaints';
        $this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{
        $this->redirectIfNotAllowed('view-complaint');

        $this->set_data('sub_menu', 'view_complain');

        $this->set_data( 'open_records', $this->Complain_model->get_open_or_assinged_complaints_list() );
        $this->set_data( 'closed_records', $this->Complain_model->get_complaints_list(STATUS_CLOSED) );
        $this->set_data( 'resolved_records', $this->Complain_model->get_complaints_list(STATUS_RESOLVED) );
		$this->load->view('complains/lists', $this->get_data());
	}

	function save($id=false)
    {
        $this->redirectIfNotAllowed( $id? 'edit-complaint': 'add-complaint', 'complaints');
		$this->set_data('sub_menu', 'add_complain');
		$record = new Complain_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);
		$this->set_data('clients', $this->Client_model->get_dropdown_lists(1));
		$this->set_data('properties', $this->Property_model->get_dropdown_lists_by_client_id($record->client_id));
		$this->set_data('users', $this->User_model->get_dropdown_lists());
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		$this->validate_form($id);

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->complain_date = db_date($this->input->post('complain_date'));

				$inserted_id_or_affected_rows = $record->save();
				if ($inserted_id_or_affected_rows) {
					if (!$id) { 
						$id=$inserted_id_or_affected_rows;
						$this->add_history($id, "Complaints added");
					}else{
                        if ($record->status == STATUS_CLOSED) 
                            $this->add_history($id, "Complaints closed.");
                        else $this->add_history($id, "Complaints updated.");
					}
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'complaints/' ) );
				}else{
					set_flash_message(2, "No changes made.!");
				}

			}
		}
		$this->load->view('complains/form',$this->get_data());
	}

	function validate_form($id)
	{
    	$this->form_validation->set_rules('data[client_id]','Choose Client','required');
    	$this->form_validation->set_rules('data[property_id]','Choose Property','required');
    	$this->form_validation->set_rules('complain_date','Complaints Date','required');
    	$this->form_validation->set_rules('data[reported_by]','Reported By','required');
    	$this->form_validation->set_rules('data[complain_details]','Complaints Details','required');
    	$this->form_validation->set_rules('data[first_response_corrective_action]','First Responsive Corrective Action','required');
    	$this->form_validation->set_rules('data[assigned_to]','Assigned ','required');
    	$this->form_validation->set_rules('data[status]','Choose Status','required');
	}

	function activation($id, $boolean=false)
	{
        $this->redirectIfNotAllowed( 'change-complaint-status', 'complaints');

		$record = new Complain_model();
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

    function get_print($id=false)
    {
    	if (!$id) {
    		set_flash_message(2, 'No Record Found!');
    		redirect('complaints/');
    	}
    	$record = new Complain_model();
    	$record->load($id);
    	
    	$this->load->library('Complainpdf');
    	$pdf = new Complainpdf($record);
    	$pdf->set_data($record);
    	$pdf->display_output();

    }

    /*************************************** FILES *****************************************/

    function files($complain_id, $action='', $file_id=0)
    {
    	switch ($action) {
    		case 'save':
    			$this->save_issues_file($complain_id, $file_id);
    			break;
    		
    		default:
    			$this->files_list($complain_id);
    			break;
    	}
    }

    function save_issues_file($complain_id, $file_id=0)
    {
    	$record = new Complain_file_model();
		if ($file_id) {
			$record->load($file_id);
		}
		$this->set_data('record', $record);

    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('complain_id', $complain_id);

    	$this->set_data('document_types', $this->Document_type_model->get_dropdown_lists());

		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			if ( $this->form_validation->run('add_client_file') ) {

				$record->complain_id 	= $complain_id;
				$record->filename  		= $this->input->post('data')['filename'];
				$record->document_type  = $this->input->post('data')['document_type'];
				$record->description 	= $this->input->post('data')['description'];
				$record->image 			= $this->input->post('data')['image'];

				$record->active = $file_id ? $record->active : 1;

				$record->{$file_id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($id = $record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "complaints/files/$complain_id/" ) );
				}else{
					set_flash_message(2, "No changes made.");
				}
			
			}

		}
    	$this->load->view('complains/file_form', $this->get_data());
    }

    function files_list($complain_id)
    {
    	$this->set_data('complain_id', $complain_id);
    	$sql = "SELECT n.id AS id, d.type AS document_type, n.description, n.filename, n.image FROM complain_file AS n 
    			JOIN document_type AS d ON d.id = n.document_type WHERE n.complain_id = $complain_id";
    	$this->set_data( 'records', $this->db->query( $sql )->result() );
		$this->load->view('complains/lists_files', $this->get_data());
    }

    function upload_complain_file($id=0)
    {
        // upload_file( $folder, $file_types, $model )
        $this->upload_file('complain_files', false, 'Complain_file_model', $id);
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
		        if ($record->image) {
		        	$this->delete_uploaded_file($folder, $record->image);
		        }
		        $record->image = $data['upload_data']['file_name'];
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
    		$record->image = '';
    		$record->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($folder, $_POST['file_name']) ) );
    	}
    }

    function history($id)
    {
        $this->load->library('form_validation');

        $this->set_data('complain_id', $id);

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('description','Description','required');
            if ( $this->form_validation->run() ) {
                $this->add_history($id, $this->input->post('description'));
                set_flash_message(0, "Record Submitted Successfully!");
                redirect( site_url( 'complaints/history/'.$id ) );
            }
        }

        $this->load->library('table');

        $this->table->set_heading('Description', 'Action by user', 'Date & Time');

        $template = array(
                'table_open' => '<table class="table table-hover table-bordered table-striped">'
        );

        $this->table->set_template($template);

        $record = new Complain_model();
        
        $record->load($id);

        $this->set_data('record', $record);

        $histories = $this->History_model->get_history_by_context_id($id, $this->context, $query_object=true);

        $this->set_data('table', $this->table->generate($histories) );

        $this->load->view('complains/history', $this->get_data());
    }

}