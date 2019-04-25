<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Client_model', 
				'Client_type_model', 
				'Contacts_model', 
				'Lead_type_model', 
				'Client_services_model', 
				'Service_model', 
				'Client_note_model', 
				'Client_file_model',
				'Property_model',
				'Client_marketing_log_model'
			));
		$this->set_data('active_menu', 'client');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'client';
	}

	function index($disable = false, $modified_item_id=0, $prospect=0, $lead=0)
	{
		$this->redirectIfNotAllowed('view-client');

		$this->set_data( 'active_list', '');
		$this->set_data( 'active_prospect_list', '');
		$this->set_data( 'inactive_list', '');
		$this->set_data( 'inactive_prospect_list', '');
		$this->set_data( 'active_lead_list', '');
		$this->set_data( 'inactive_lead_list', '');

		if ($prospect) {
			$this->set_data( 'active_prospect_list', ($disable)?'':'active');
			$this->set_data( 'inactive_prospect_list', !($disable)?'':'active');
		}elseif ($lead) {
			$this->set_data( 'active_lead_list', ($disable)?'':'active');
			$this->set_data( 'inactive_lead_list', !($disable)?'':'active');
		}else{
			$this->set_data( 'active_list', ($disable)?'':'active');
			$this->set_data( 'inactive_list', !($disable)?'':'active');
		}
		
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data('sub_menu', 'active_client_lists');
		
		$this->set_data( 'records', $this->Client_model->get_list_where( 1, 0) );
		$this->set_data( 'prospect_records', $this->Client_model->get_list_where( 1, 1 ) );
		$this->set_data( 'lead_records', $this->Client_model->get_list_where( 1, 0, 1 ) );

		$this->set_data( 'inactive_records', $this->Client_model->get_list_where( 0, 0 ) );
		$this->set_data( 'inactive_prospect_records', $this->Client_model->get_list_where( 0, 1 ) );
		$this->set_data( 'inactive_lead_records', $this->Client_model->get_list_where( 0, 0, 1 ) );
		
		$this->load->view('clients/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-client':'add-client');
		$record = new Client_model();
		if ($id) {
			$this->set_data('sub_menu', 'add_client');
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');
		$this->set_data('client_types',  $this->Client_type_model->dropdown_list() ); // set data

		$this->db->order_by('name');
		$this->set_data(
			'parent_clients', 
			array_map(function($o){ 
					return $o->name; 
				}, $this->Client_model->getWhere(array('active'=>1, 'is_parent'=>1))
			) // array_map
		); // set data

		$this->set_data(
			'lead_types', 
			array_map(function($o){ 
					return $o->type; 
				}, $this->Lead_type_model->getWhere(array('active'=>1))
			) // array_map
		); // set data

		if( isset($_POST['submit']) )
		{
			$this->set_conditional_validation_roles();

			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} = $value;
				}
				$record->is_parent = $this->input->post('data[is_parent]')? 1: 0;
				if (!$record->is_parent) {
					$record->child_of = $this->input->post('data[child_of]')? $this->input->post('data[child_of]'): null;
				}else{
					$record->child_of = null;
				}
				$record->same_billing_address = $this->input->post('data[same_billing_address]')? 1: 0;

				$clientType = $this->input->post('data[is_prospect]');

				if($clientType == 0)
				{
					$record->is_lead = 0;
					$record->is_prospect = 0;
				}

				if($clientType == 1)
				{
					$record->is_lead = 0;
					$record->is_prospect = 1;
				}

				if($this->input->post('data[is_prospect]') == 2)
				{
					$record->is_lead = 1;
					$record->is_prospect = 0;
					// dd($this->input->post());
					$record->lead_date = db_date($this->input->post('lead_date'));

					$marketingDescription = sprintf("Leads created by %s on %s - %s", 
						$this->session->userdata('fullname'),
						$this->input->post('lead_date'),
						LeadType::find($this->input->post('data[client_type]'))->type
					);

					$marketing = Marketing::create([
						'description' => $marketingDescription,
						'description' => $marketingDescription,
						'date' => $record->lead_date,
						'created_by' => $this->session->userdata('user_id'),
					]);
				}
				
				$record->active = $id? $record->active: 1;

				$inserted_id_or_affected_rows = $record->save();

				if(!$id)
				{
					// $marketing->lead_id = $inserted_id_or_affected_rows;
					// $marketing->save();
					$marketingDescription = sprintf("Leads created by %s on %s - %s", 
						$this->session->userdata('fullname'),
						$this->input->post('lead_date'),
						LeadType::find($this->input->post('data[client_type]'))->type
					);
					$note = new Client_marketing_log_model();
					$note->note = $marketingDescription;
					$note->added_by = $this->session->userdata('user_id');
					$note->client_id = $inserted_id_or_affected_rows;
					$note->save();
				}

				if ($inserted_id_or_affected_rows) 
				{
					$msg = $record->is_prospect? "Prospect ": "Client ";
					if (!$id) { 
						$id = $inserted_id_or_affected_rows;
						$this->add_history($id, $msg . " added ");
					}else{
						$this->add_history($id, $msg . " Upldated ");
					}
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'client/' ) );
				}

			}
		}

		$this->load->view('clients/form',$this->get_data());
	}

	function set_conditional_validation_roles()
	{
    	$this->form_validation->set_rules('data[name]','Client name','required|max_length[255]');
    	$this->form_validation->set_rules('data[client_type]','Client type','required|numeric');
    	$this->form_validation->set_rules('data[phone]','Phone number','required|max_length[255]');
    	$this->form_validation->set_rules('data[email]','Email Address','required|valid_email|max_length[255]');
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

		// if ( $this->input->post('data[is_prospect]') == 2 ) {
    	// 	$this->form_validation->set_rules('data[lead_by]','Lead by','required');
    	// 	$this->form_validation->set_rules('lead_date','Lead date','required');
		// }
	}

	function delete($id)
	{
		$this->redirectIfNotAllowed('delete-client');

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
		$this->redirectIfNotAllowed('change-client-status');
		$record = new Client_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			$this->add_history($id, "Client reactivated");
			set_flash_message(0, 'Client status changed to active');
			redirect( site_url( 'client/index/0/'.$id . '/'.$record->is_prospect ) );
		}else{
			$this->add_history($id, "Client inactivated");
			set_flash_message(0, 'Client status changed to inactive');
			redirect( site_url( 'client/index/1/'.$id . '/'.$record->is_prospect ) );
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

   	public function export($type='clients')
   	{
   		if ($type == 'clients') 
   		{

	   		$this->load->library('ClientCsvExport');

	   		$csv = new ClientCsvExport('Client_model');	

   		}else{
   			
	   		$this->load->library('ProspectCsvExport');

	   		$csv = new ProspectCsvExport('Client_model');
   		}

   		$csv->excludeColumns(['child_of', 'is_prospect']);

   		$csv->export();
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

    		case 'add_contact_service':
    			$this->add_ajax_contact();
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
			
           	$this->form_validation->set_rules('data[contact_name]','Contact name','required');
           	$this->form_validation->set_rules('data[email]','Email','required');
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
    	$this->redirectIfNotAllowed('change-client-contact-status', 'client');

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
    	$this->redirectIfNotAllowed('add-client-contact', 'client');
    	$this->set_data('sub_menu', 'x');
    	
    	$this->set_data('client_id', $client_id);

		$this->load->library('form_validation');

		$this->set_data('client_types',  $this->Client_type_model->dropdown_list() );
		
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
    function add_ajax_contact()
    {
		$this->load->library('form_validation');
    	if( isset($_POST['client_id']) ){

			$this->form_validation->set_rules(array(
			        array(
			            'field' => 'contact_name',
			            'label' => 'Contact name',
			            'rules' => 'required|max_length[255]'
			        ),
			        array(
			            'field' => 'surname',
			            'label' => 'Surname',
			            'rules' => 'required'
			        ),
			        array(
			            'field' => 'phone',
			            'label' => 'Phone number',
			            'rules' => 'required|max_length[255]'
			        ),
			        array(
			            'field' => 'email',
			            'label' => 'Email Address',
			            'rules' => 'required|valid_email|max_length[255]'
			        )

			    )
		    );

			if ( $this->form_validation->run() ) {
			
				$record = new Contacts_model();

				$record->client_id 		= $_POST['client_id'];
				$record->contact_name 	= $_POST['contact_name'];
				$record->surname 		= $_POST['surname'];
				$record->role 			= $_POST['role'];
				$record->phone 			= $_POST['phone'];
				$record->email 			= $_POST['email'];
				$record->is_primary 	= $_POST['is_primary'];

				if ($id = $record->save()) {

					if( $this->input->post('data[is_primary]') ){
						$this->remove_old_primary($record->client_id, $id);
					}

					$this->add_history($record->client_id, "New contact created ");
					
					$e = array('error'=>false, 'record' => $record);
					echo json_encode($e);
				}
			
			}else{
				$e = array('error'=>true, 'message' => validation_errors());
				echo json_encode($e);
			}

		}
    }

    function contact_lists($client_id)
    {
    	$this->redirectIfNotAllowed('view-client-contact', 'client');
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
    	return $this->Document_type_model->get_dropdown_lists();
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

    function history($id)
    {
        $this->load->library('form_validation');

        $this->set_data('client_id', $id);

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('description','Description','required|max_length[255]');
            if ( $this->form_validation->run() ) {
                $this->add_history($id, $this->input->post('description'));
                set_flash_message(0, "Record Submitted Successfully!");
                redirect( site_url( 'client/history/'.$id ) );
            }
        }

        $this->load->library('table');

        $this->table->set_heading('Description', 'Action by user', 'Date & Time');

        $template = array(
                'table_open' => '<table class="table table-hover table-bordered table-striped">'
        );

        $this->table->set_template($template);

        $client = new Client_model();
        
        $client->load($id);

        $this->set_data('record', $client);

        $histories = $this->History_model->get_history_by_context_id($id, $client->context, $query_object=true);

        $this->set_data('table', $this->table->generate($histories) );

        $this->load->view('clients/history', $this->get_data());
    }

    /***************************** PROPERTY **********************************/
    
    function properties($client_id, $disable = false, $modified_item_id=0)
    {
    	$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		
		$this->set_data( 'sub_menu', 'view_property');
		$this->set_data( 'client_id', $client_id);
		
		$sql = "SELECT p.*, c.name FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE client_id = $client_id AND p.active = ";
		$this->set_data( 'records', $this->db->query($sql."1")->result() );
    	$this->set_data( 'inactive_records', $this->db->query($sql."0")->result() );

		$this->load->view('clients/lists_property', $this->get_data());
    }

    /****************************** Services *********************************/

	function get_properties_service()
	{
		if (isset($_POST['client_id'])) {
			$properties = $this->Property_model->get_dropdown_lists_by_client_id($_POST['client_id'], 1);
			echo json_encode($properties);
		}
	}

	function get_contacts_service()
	{
		if (isset($_POST['client_id'])) {
			$properties = $this->Contacts_model->get_dropdown_lists($_POST['client_id']);
			echo json_encode($properties);
		}
	}

	function send_credentails()
	{
		if ( !in_array('can-change-client-username-password', $this->data['roles']) ) 
		{
			return $this->sendResponse(['message' => 'Unauthenticated', 'code' => 401], 401);
		}

		if (!isset($_POST['client_id'])) 
		{
			return $this->sendResponse(['error' => 'not found'], 404);
		}

		$client = new Client_model();

		$client->load($this->input->post('client_id'));

		return $this->sendResponse(['username' => $client->username]);
	}

	public function change_password()
	{
		if ( !in_array('can-change-client-username-password', $this->data['roles']) ) 
		{
			return $this->sendResponse(['message' => 'Unauthenticated', 'code' => 401]);
		}

		if ( !isset($_POST['client_id']) )
		{
			return $this->sendResponse(['error', 404]);
		}

    	$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username','required|callback_custom_username_check['.$this->input->post('client_id').']');
        $this->form_validation->set_rules('password','Password','required|min_length[3]|max_length[15]');
        $this->form_validation->set_rules('password_confirmation','Confirm Password','required|matches[password]');

        if( $this->form_validation->run() === false )
        {
            return $this->sendResponse($this->form_validation->error_array(), 422);
        }

		$client = new Client_model();

		$client->load($this->input->post('client_id'));

		$client->username = $this->input->post('username');

		$client->password = password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost'=>12));

		$client->save();

		return $this->sendResponse(['message' => 'username / password has changed successfully.']);
		// return $this->sendResponse($this->input->post());
	}

	public function change_type($id, $type)
    {
		$lead = new Client_model();
		$lead->load($id);

		if(!$lead || !$lead->is_lead)
			die('only leade can be changed');

		if($type == 'prospect')
		{
			$lead->is_prospect = 1;
			$lead->is_lead = 0;
		}

		if($type == 'client')
		{
			$lead->is_prospect = 0;
			$lead->is_lead = 0;
		}

		$lead->save();


		$marketingDescription = sprintf("Record changed from Lead to %s on %s by %s", 
			$type,
			(new DateTime())->format('d/m/Y H:i:s'),
			$this->session->userdata('fullname')
		);

		Marketing::create([
			'description' => $marketingDescription,
			'date' => (new DateTime())->format('Y-m-d'),
			'created_by' => $this->session->userdata('user_id'),
		]);

		$note = new Client_marketing_log_model();
		$note->note = $marketingDescription;
		$note->added_by = $this->session->userdata('user_id');
		$note->client_id = $id;
		$note->save();

		set_flash_message(0, "Action Successful!");
		redirect( site_url( '/' ) );
    }

	public function custom_username_check($user_name,$id)
    {
        $this->db->where('username',$user_name);
        
        $this->db->where('id !=',$id);
        
        $users = $this->db->get('client');
        
        if($users->row())
        {
            $this->form_validation->set_message('custom_username_check', 'The {field} must be unique. This is already in use.');

            return false;
        }

        return true;
    }

	public function suburbs()
	{
		$this->db->distinct('address_suburb')
				->select('address_suburb')
				->order_by('address_suburb');
		$suburbs = $this->db->get('client')->result();
		$this->sendResponse($suburbs);
	}

}