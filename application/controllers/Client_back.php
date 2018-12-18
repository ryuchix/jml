<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Client_model', 'Client_type_model', 'Contacts_model', 'Client_services_model', 'Service_model', 'Client_note_model', 'Client_file_model'));
		$this->set_data('active_menu', 'client');
		$this->history_context = 'client';
	}

	function index($disable = false, $modified_item_id=0)
	{
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		$this->set_data('sub_menu', 'active_client_lists');
		$this->set_data( 'records', $this->Client_model->getWhere( array( 'active' => 1 ) ) );
    	$this->set_data( 'inactive_records', $this->Client_model->getWhere( array( 'active' => 0 ) ) );
		$this->load->view('clients/lists', $this->get_data());
	}

	function add(){

		$this->set_data('sub_menu', 'add_client');
		$this->load->library('form_validation');

		$this->set_data('client_types',  $this->get_client_type_dropdown_list_data() ); // set data

		$this->set_data(
			'parent_clients', 
			array_map(function($o){ 
					return $o->name; 
				}, $this->Client_model->getWhere(array('active'=>1, 'is_parent'=>1))
			) // array_map
		); // set data
		
		if( isset($_POST['submit']) ){

			$this->set_conditional_validation_roles();

			if ( $this->form_validation->run() ) {
			
				$record = new Client_model();
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->is_parent	  		= $this->input->post('data[is_parent]')? 1:0;
				if (!$record->is_parent) {
					$record->child_of 	  		= $this->input->post('data[is_parent]')? $this->input->post('data[child_of]'): null;
				}
				$record->same_billing_address= $this->input->post('data[same_billing_address]')? 1: 0;
				$record->active 	  		= 1;

				if ($id = $record->save()) {
					$this->add_history($id, "Client added ");
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'client/' ) );
				}
			
			}

		}
		$this->load->view('clients/add', $this->get_data());
	}

	function edit($id){
		$this->load->library('form_validation');
		$record = new Client_model();
		$record->load($id);
		$this->set_data('record', $record);

		$this->set_data('client_types',  $this->get_client_type_dropdown_list_data() ); // set data

		$this->set_data(
			'parent_clients', 
			array_map(function($o){ 
					return $o->name; 
				}, $this->Client_model->getWhere(array('active'=>1, 'is_parent'=>1, 'id !=' => $id))
			) // array_map
		); // set data

		if (isset($_POST['submit'])) {

			$this->set_conditional_validation_roles();
           	
           	$this->form_validation->set_rules('data[name]','Client name','required|callback_custom_client_name_check['.$id.']');
           	
           	$this->form_validation->set_rules('data[email]','Client email','required|callback_custom_client_email_check['.$id.']');

           	if ($this->form_validation->run() == TRUE ) {
           		
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->is_parent	  		= $this->input->post('data[is_parent]')? 1:0;
				$record->child_of 	  		= !$this->input->post('data[is_parent]')? $this->input->post('data[child_of]'): null;

				$record->same_billing_address= $this->input->post('data[same_billing_address]')? 1: 0;

				if ($record->save()) {
					$this->add_history($id, "Client updated");
					set_flash_message(0, "Record saved!");
					redirect( site_url( 'client/' ) );
				}else{
					set_flash_message(0, "No changes made!");
				}
           	}
		}
		$this->load->view('clients/edit', $this->get_data());
	}

	function get_client_type_dropdown_list_data()
	{
		return array_map(
					function($o){ 
						return $o->type; 
					}, 
					$this->Client_type_model->getWhere(array('active'=>1))
				); // array_map
	}

	function set_conditional_validation_roles()
	{
		
    	$this->form_validation->set_rules('data[name]','Client name','required|is_unique[client.name]|max_length[255]');
    	$this->form_validation->set_rules('data[client_type]','Client type','required|numeric');
    	$this->form_validation->set_rules('data[phone]','Phone number','required|max_length[255]');
    	$this->form_validation->set_rules('data[email]','Email Address','required|valid_email|is_unique[client.email]|max_length[255]');
    	// $this->form_validation->set_rules('data[address_1]','Address 1','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_state]','State','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_suburb]','Suburb','required|max_length[255]');
    	$this->form_validation->set_rules('data[attention]','Attention','required|max_length[255]');

		if ( !$this->input->post('data[is_parent]') ) {
    		$this->form_validation->set_rules('data[child_of]','Parent client','required');
		}

		if ( !$this->input->post('data[same_billing_address]') ) {
    		// $this->form_validation->set_rules('data[billing_address_1]','Billing Address 1','required|max_length[255]');
    		$this->form_validation->set_rules('data[billing_state]','State','required|max_length[255]');
    		$this->form_validation->set_rules('data[billing_suburb]','Suburb','required|max_length[255]');
    		$this->form_validation->set_rules('data[billing_post_code]','Post Code','required|max_length[255]');
		}
	}

	function delete($id){
		$record = new Client_type_model();
		$record->load($id);
		if ($record->delete()) {
			set_flash_message(0, 'Record Successfully Deleted');
			redirect( site_url( 'client_type' ) );
		}else{
			set_flash_message(1, 'There may some problem while deleting record');
			redirect( site_url( 'client_type' ) );
		}
	}

	function map($id){
		$record = new Client_model();
		$record->load($id);
		$this->set_data('record', $record);
		$this->load->view('clients/map', $this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$record = new Client_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			$this->add_history($id, "Client reactivated");
			set_flash_message(0, 'Client status changed to active');
			redirect( site_url( 'client/index/0/'.$id ) );
		}else{
			$this->add_history($id, "Client inactivated");
			set_flash_message(0, 'Client status changed to inactive');
			redirect( site_url( 'client/index/1/'.$id ) );
		}
	}

    public function custom_client_name_check($name,$id){
        $this->db->where('name',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('client');
        if($users->row()){
            $this->form_validation->set_message('custom_client_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    public function custom_client_email_check($email,$id){
        $this->db->where('email',$email);
        $this->db->where('id !=',$id);
        $users = $this->db->get('client');
        if($users->row()){
            $this->form_validation->set_message('custom_client_email_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    function contact( $client_id, $action )
    {
    	switch( $action ){

    		case 'add':
    			$this->add_contact($client_id);
    		break;

    		case 'list':
    			$this->contact_lists($client_id);
    		break;

    		case 'inactive':
    			$contact_id = $client_id;
    			$this->contact_toggle_active($contact_id,false);
    		break;

    		case 'active':
    			$contact_id = $client_id;
    			$this->contact_toggle_active($contact_id,true);
    		break;

    		case 'edit':
    			$contact_id = $client_id;
    			$this->edit_contact($contact_id);
    		break;

    	}
    }

    function edit_contact($contact_id)
    {
    	$this->load->library('form_validation');

    	$this->set_data('sub_menu', 'x');
    	
		$contact = new Contacts_model();
		
		$contact->load($contact_id);
    	
    	$this->set_data('client_id', $contact->client_id);
		
		$this->set_data('record', $contact);
		
		if( isset($_POST['submit']) ){
			
           	$this->form_validation->set_rules('data[contact_name]','Contact name','required|callback_custom_contact_contact_name_check['.$contact_id.'|'.$contact->client_id.']');
           	$this->form_validation->set_rules('data[email]','Email','required|callback_custom_contact_email_check['.$contact_id.'|'.$contact->client_id.']');
           	$this->form_validation->set_rules('data[surname]','Surname','required');
           	$this->form_validation->set_rules('data[phone]','Phone','required|max_length[255]');
			
			if ( $this->form_validation->run() == true ) {
			
				$record = new Contacts_model();
				$record->load($contact_id);

				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				if( $this->input->post('data[is_primary]') ){
					$this->remove_old_primary($record->client_id, $contact_id);
				}else{
					$record->is_primary = $this->input->post('data[is_primary]');
				}

				if ($record->save()) {					

					$this->add_history($record->client_id, "Contact Updated ");
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "client/contact/".$record->client_id."/list" ) );
				}
			
			}

		}

		$this->load->view('clients/edit_contact', $this->get_data());
    }

    public function custom_contact_email_check($email,$ids){
    	$ids = explode('|', $ids);
    	$contact_id = $ids[0];
    	$client_id = $ids[1];

        $this->db->where('email',$email);
        $this->db->where('id !=',$contact_id);
        $this->db->where('client_id !=',$client_id);
		$users = $this->db->get('contacts');
        if($users->row()){
            $this->form_validation->set_message('custom_contact_email_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    public function custom_contact_contact_name_check($contact_name,$ids){
    	$ids = explode('|', $ids);
    	$contact_id = $ids[0];
    	$client_id = $ids[1];

        $this->db->where('contact_name',$contact_name);
        $this->db->where('id !=',$contact_id);
        $this->db->where('client_id !=',$client_id);
		$users = $this->db->get('contacts');
        if($users->row()){
            $this->form_validation->set_message('custom_contact_contact_name_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

    function contact_toggle_active($contact_id, $toggle)
    {
    	$contact = new Contacts_model();
    	$contact->load($contact_id);
    	$contact->active = $toggle;
    	$contact->save();

    	$message = sprintf("Contact status change to %s", $toggle?"active":"inactive");
    	$this->add_history($contact->client_id, $message);
    	set_flash_message(0, $message);
    	redirect( site_url( 'client/contact/'.$contact->client_id.'/list' ) );
    }

    function add_contact($client_id)
    {
    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('client_id', $client_id);

		$this->load->library('form_validation');

		$this->set_data('client_types',  $this->get_client_type_dropdown_list_data() );
		
		if( isset($_POST['submit']) ){
			
			if ( $this->form_validation->run('add_client_contact') ) {
			
				$record = new Contacts_model();

				$record->client_id = $client_id;

				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				if ($id = $record->save()) {
					
					if( $this->input->post('data[is_primary]') ){
						$this->remove_old_primary($client_id, $id);
					}

					$this->add_history($client_id, "New contact created ");
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "client/contact/$client_id/list" ) );
				}
			
			}

		}

		$this->load->view('clients/add_contact', $this->get_data());
    }

    function contact_lists($client_id)
    {
    	$this->set_data('client_id', $client_id);
    	$this->set_data( 'records', $this->Contacts_model->getWhere( array('active'=>1, 'client_id'=>$client_id) ) );
    	$this->set_data( 'inactive_records', $this->Contacts_model->getWhere( array('active'=>0, 'client_id'=>$client_id) ) );
		$this->load->view('clients/lists_contact', $this->get_data());
    }

    function remove_old_primary($client_id, $id)
    {
		$sql = "UPDATE `contacts` SET `is_primary`= 0 WHERE `client_id` = ".$this->db->escape($client_id) ." AND `id` != ". $this->db->escape($id);
		$this->db->query($sql);
    }

    function service( $client_id, $action )
    {
    	switch( $action ){

    		case 'add':
    			$this->add_service($client_id);
    		break;

    		case 'list':
    			$this->services_list($client_id);
    		break;

    		case 'remove':
    			$service_id = $client_id;
    			$this->remove_service($service_id);
    		break;

    	}
    }

    function remove_service($service_id)	
    {
    	$record = new Client_services_model();
    	$record->load($service_id);

    	$service = new Service_model();
    	$service->load($record->service_id);

    	if ($record->delete()) {
			$this->add_history($record->client_id, "Service ".$service->name .' has been removed.');
			set_flash_message(0, "Record Deleted Successfully!");
			redirect( site_url( "client/service/".$record->client_id."/list" ) );
    	}
    }

    function add_service($client_id)
    {
    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('client_id', $client_id);

		$this->load->library('form_validation');

		$this->set_data('services',  $this->get_services_dropdown_list_data($client_id) );

		if( isset($_POST['submit']) ){
    	
    		$this->form_validation->set_rules('serivce_id','Service','required|numeric');
			
			if ( $this->form_validation->run() == true ) {
			
				$record = new Client_services_model();

				$record->client_id = $client_id;
				$record->service_id = $this->input->post('serivce_id');

				if ($id = $record->save()) {

			    	$service = new Service_model();
			    	$service->load($record->service_id);

					$this->add_history($client_id, "Service ".$service->name .' has been added.');
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "client/service/$client_id/list" ) );
				}
			}

		}

		$this->load->view('clients/client_service_form', $this->get_data());
    }

    function get_services_dropdown_list_data($client_id)
    {
    	$sql = "SELECT s.id, s.name FROM service AS s WHERE s.id NOT IN (
			SELECT service_id FROM client_services WHERE client_id = $client_id
    	) AND s.active = 1";
    	$query = $this->db->query($sql);
    	$ret = array();

    	foreach ($query->result() as $row) {
    		$ret[$row->id] = $row->name;
    	}
    	return $ret;
    }

    function services_list($client_id)
    {
    	$this->set_data('client_id', $client_id);
    	$sql = "SELECT cs.id AS id, s.name, s.description FROM service AS s JOIN client_services AS cs ON s.id = cs.service_id WHERE s.active = 1 AND cs.client_id = $client_id";
    	$this->set_data( 'records', $this->db->query( $sql )->result() );
		$this->load->view('clients/lists_services', $this->get_data());
    }

    function notes($client_id, $action='', $note_id=0)
    {
    	switch ($action) {
    		case 'save':
    			$this->save_client_note($client_id, $note_id);
    			break;
    		
    		default:
    			$this->notes_list($client_id);
    			break;
    	}
    }

    function save_client_note($client_id, $note_id=0)
    {
    	$record = new Client_note_model();
		if ($note_id) {
			$record->load($note_id);
		}
		$this->set_data('record', $record);
    	// $ext = pathinfo($filename, PATHINFO_EXTENSION);
    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('client_id', $client_id);

    	$this->set_data('document_types', $this->get_document_types());

		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			if ( $this->form_validation->run('add_client_note') ) {

				$record->client_id = $client_id;
				$record->document_type  = $this->input->post('data')['document_type'];
				$record->user_roles 	= implode(',', $this->input->post('data')['user_roles']);
				$record->notes 			= $this->input->post('data')['notes'];
				$record->image 			= $this->input->post('data')['image'];

				$record->active = $note_id ? $record->active : 1;

				$record->{$note_id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($id = $record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "client/notes/$client_id/" ) );
				}else{
					set_flash_message(2, "No changes made.");
				}
			
			}

		}
    	$this->load->view('clients/note_form', $this->get_data());
    }

    function notes_list($client_id)
    {
		// $this->set_data('document_types_name', $this->get_document_types_name());
    	
    	$this->set_data('client_id', $client_id);
    	$sql = "SELECT n.id AS id, d.type AS document_type, n.notes, n.image FROM client_note AS n 
    			JOIN document_type AS d ON d.id = n.document_type WHERE n.client_id = $client_id";
    	$this->set_data( 'records', $this->db->query( $sql )->result() );
		$this->load->view('clients/lists_notes', $this->get_data());
    }

    function get_document_types()
    {
    	$this->load->model('Document_type_model');
    	return array_map(
					function($o){ 
						return $o->type; 
					}, 
					$this->Document_type_model->getWhere(array('active'=>1))
				); // array_map
    }

    function get_document_types_name()
    {
    	$types = $this->get_document_types();
    	$ret = array();

    	foreach ($types as $id => $record) {
    		$ret[$id] = $record->type;
    	}

    	return $ret;
    }

    function files($client_id, $action='', $file_id=0)
    {
    	switch ($action) {
    		case 'save':
    			$this->save_client_file($client_id, $file_id);
    			break;
    		
    		default:
    			$this->files_list($client_id);
    			break;
    	}
    }

    function save_client_file($client_id, $file_id=0)
    {
    	$record = new Client_file_model();
		if ($file_id) {
			$record->load($file_id);
		}
		$this->set_data('record', $record);

    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('client_id', $client_id);

    	$this->set_data('document_types', $this->get_document_types());

		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			if ( $this->form_validation->run('add_client_file') ) {

				$record->client_id = $client_id;
				$record->filename  = $this->input->post('data')['filename'];
				$record->document_type  = $this->input->post('data')['document_type'];
				$record->description 	= $this->input->post('data')['description'];
				$record->image 			= $this->input->post('data')['image'];

				$record->active = $file_id ? $record->active : 1;

				$record->{$file_id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($id = $record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( "client/files/$client_id/" ) );
				}else{
					set_flash_message(2, "No changes made.");
				}
			
			}

		}
    	$this->load->view('clients/file_form', $this->get_data());
    }

    function files_list($client_id)
    {
    	$this->set_data('client_id', $client_id);
    	$sql = "SELECT n.id AS id, d.type AS document_type, n.description, n.filename, n.image FROM client_file AS n 
    			JOIN document_type AS d ON d.id = n.document_type WHERE n.client_id = $client_id";
    	$this->set_data( 'records', $this->db->query( $sql )->result() );
		$this->load->view('clients/lists_files', $this->get_data());
    }

    function upload_client_file($id=0)
    {
        // upload_file( $folder, $file_types, $model )
        $this->upload_file('client_files', false, 'Client_file_model', $id);
    }

    function upload_client_note($id=0)
    {
        // upload_file( $folder, $file_types, $model )
        $this->upload_file('client_notes', 'gif|jpg|png|tif|doc|docx|word|pdf', 'Client_note_model', $id);
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

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8