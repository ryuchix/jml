<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumable_request extends MY_Controller
{
	private $gellary_upload_error = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Property_model', 
				'Consumable_model', 
				'Consumable_request_model', 
				'Consumable_request_item_model', 
				'Client_model', 
				'User_model', 
			));
		$this->set_data('active_menu', 'consumable');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'consumable_request';
	}

	function index()
	{
		$this->redirectIfNotAllowed('view-consumable-request');
		$this->set_data( 'sub_menu', 'add_consumable_request');
		// if ($this->session->userdata('user_role')==ADMIN_ROLE) {
			$this->set_data( 'awaiting_for_approval', $this->Consumable_request_model->get_list(STATUS_AWAITING_FOR_APPROVAL) );
			$this->set_data( 'open_records', $this->Consumable_request_model->get_list(STATUS_OPEN) );
			$this->set_data( 'closed_records', $this->Consumable_request_model->get_list(STATUS_CLOSED) );
			$this->set_data( 'void_records', $this->Consumable_request_model->get_list(STATUS_VOID) );
			$this->set_data( 'approved_records', $this->Consumable_request_model->get_list(STATUS_APPROVED) );
		// }else{
		// 	$current_user_id = $this->session->userdata('user_id');
		// 	$this->set_data( 'open_records', $this->Consumable_request_model->get_list(STATUS_OPEN, $current_user_id) );
		// 	$this->set_data( 'closed_records', $this->Consumable_request_model->get_list(STATUS_CLOSED, $current_user_id) );
		// 	$this->set_data( 'void_records', $this->Consumable_request_model->get_list(STATUS_VOID, $current_user_id) );
		// }

		$this->load->view('consumables_request/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-consumable-request': 'add-consumable-request');
		$record = new Consumable_request_model();
		$this->set_data( 'selected_items', array() );
		$client = new Client_model();
		$property = new Property_model();
		$this->set_data( 'users', $this->User_model->get_dropdown_lists() );
		$this->set_data( 'items', [] );
		
		if ($id) {
			$record->load($id);
			$property->load($record->property_id);
			$client->load($property->client_id);
			$this->set_data( 'items', $this->Consumable_request_item_model->get_consumable_items_by_property_id($record->property_id) );
			$this->set_data( 'selected_items', $this->Consumable_request_item_model->getWhere(['request_id'=>$record->id]) );
			// x($this->data['selected_items']);
		}

		if ($p = $this->input->post('data[property_id]')) {
			$this->set_data( 'items', $this->Consumable_request_item_model->get_consumable_items_by_property_id($p) );
		}
			// x($this->data['items']);

		$this->set_data('record', $record);
		$this->load->library('form_validation');
		$this->set_data( 'properties', $this->Property_model->get_dropdown_lists() );
		$this->set_data( 'client', $client );
		$this->set_data( 'property', $property );

		if( isset($_POST['submit']) ){
			
			$this->validate_form($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) 
				{
					$record->{$field} = $value;
				}

				$record->status = $this->input->post('status')? $this->input->post('status'): 0;

				$record->date = db_date($this->input->post('request_date'));

				if(!$id) { $record->added_by = $this->session->userdata('user_id'); }

				$inserted_result = 1;
				$inserted_result = $record->save();

				if ( $inserted_request_id = $id? $id: $inserted_result ) 
				{
					$this->Consumable_request_item_model->deleteWhere(array('request_id'=>$inserted_request_id));
					foreach ($this->input->post('items') as $item) {
						// x($item);
						if (!array_key_exists('id', $item)) { continue; }
						$ordered_item = new Consumable_request_item_model();
						$ordered_item->consumable_id = $item['id'];
						$ordered_item->request_id 	 = $inserted_request_id;
						$ordered_item->qty 	 		 = $item['qty'];
						$ordered_item->unit 	 	 = $item['unit'];
						$ordered_item->save();
						// x($this->db->error());
					}
					$this->add_history($inserted_request_id, !$id? "Request Added":"Request Updated");
					$this->comsumableRequested($record);
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'] ) );
				}
			}
		}


		$this->load->view('consumables_request/form',$this->get_data());
	}
	
	function comsumableRequested($consumable)
	{
		if (!$consumable) 
		{
			return;
		}

		$this->load->library('email');

		$data = $this->getConsumableData($consumable->id);

		$this->email->from('noreply@jmlcleaningservices.com.au', 'JML Cleaning Services');

		$this->email->to('office@jmlcleaningservices.com.au');

		$this->email->bcc('hdarif2@gmail.com');

		$this->email->subject( 'Consumable Requested by ' . $data['requested_by']->first_name .' '.$data['requested_by']->last_name );

		$body = $this->load->view('emails/consumable_requested', $data, true);
		
		$this->email->message($body);

		$this->email->send();
	}
	
	function requestApproved($consumable)
	{
		$this->load->library('email');

		$this->email->from('noreply@jmlcleaningservices.com.au', 'JML Cleaning Services');
		$this->email->reply_to('info@jmlcleaningservices.com.au');
		$this->email->to('info@jmlcleaningservices.com.au');
		$this->email->bcc('hdarif2@gmail.com');

		$this->email->subject( 'Order from JML Cleaning Services' );
		$body = $this->load->view('emails/consumable_requested_approved', $this->getConsumableData($consumable->id), true);
		$this->email->message($body);

		$this->email->send();
	}

	protected function getConsumableData($id)
	{
		
		$consumable = new Consumable_request_model();
		$consumable->load($id);

		$data['consumable'] = $consumable;

		$property = new Property_model();
		$property->load($consumable->property_id);

		$data['property'] = $property;
		
		$requested_by = new User_model();
		$requested_by->load($consumable->request_by);
		$data['requested_by'] = $requested_by;

		$client = new Client_model();
		$client->load($property->client_id);
		$data['client'] = $client;

		$lineItems = $this->db->query("SELECT ci.id, c.ref_code AS code, s.name AS supplier, ci.consumable_id, c.name, ci.qty, ci.unit 
										FROM `consumable_request_item` AS ci
										JOIN consumable_request cr ON ci.request_id = cr.id
										JOIN consumable AS c ON c.id = ci.consumable_id
										JOIN supplier AS s ON c.supplier_id = s.id
										WHERE cr.id = ?", [$consumable->id])->result();
		$data['lineItems'] = $lineItems;

		return $data;
	}


	function validate_form($id)
	{
       	$this->form_validation->set_rules('data[property_id]','Property','required');
       	$this->form_validation->set_rules('data[po_no]','PO No.','required');
       	$this->form_validation->set_rules('data[status]','Status','required');
       	$this->form_validation->set_rules('data[request_by]','Request By','required');
       	$this->form_validation->set_rules('request_date','Request Date','required');
	}

    function approve($id)
    {
		$this->redirectIfNotAllowed('can-approve-consumable-request');
        
        $consumable = new Consumable_request_model();
        $consumable->load($id);

        $approvedBy = new User_model();
        $approvedBy->load($this->session->userdata('user_id'));

        $consumable->approved_by = $approvedBy->id;
        $consumable->approved_at = date('Y-m-d h:i:s');
        $consumable->status = STATUS_APPROVED;
        $consumable->save();

        $this->requestApproved($consumable);
		
		$this->add_history($id, "Approved By ".$approvedBy->first_name . ' ' . $approvedBy->last_name);
		set_flash_message(0, "Request Approved Successfully and an email is sent to supplier!");
        redirect( site_url( $this->data['class_name'] ) );
    }

    function history($id)
    {
		$this->redirectIfNotAllowed('view-consumable-request-history');
        
        $this->load->library('form_validation');

        $this->set_data('property_id', $id);

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('description','Description','required|max_length[255]');
            if ( $this->form_validation->run() ) {
                $this->add_history($id, $this->input->post('description'));
                set_flash_message(0, "Record Submitted Successfully!");
                redirect( site_url( 'property/history/'.$id ) );
            }
        }

        $this->load->library('table');

        $this->table->set_heading('Description', 'Action by user', 'Date & Time');

        $template = array(
                'table_open' => '<table class="table table-hover table-bordered table-striped">'
        );

        $this->table->set_template($template);

        // $record = new Property_model();
        
        // $record->load($id);

        // $this->set_data('record', $record);

        $histories = $this->History_model->get_history_by_context_id($id, $this->context, $query_object=true);

        $this->set_data('table', $this->table->generate($histories) );

        $this->load->view('consumables_request/history', $this->get_data());
    }

    /**************************************** Services **************************************/
    function get_consumable_items_service()
    {
    	if (isset($_POST['property_id'])) {
			$items = $this->Consumable_request_item_model->get_consumable_items_by_property_id($_POST['property_id']);
			echo json_encode($items);
    	}
    }

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8