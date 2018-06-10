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
			$this->set_data( 'open_records', $this->Consumable_request_model->get_list(STATUS_OPEN) );
			$this->set_data( 'closed_records', $this->Consumable_request_model->get_list(STATUS_CLOSED) );
			$this->set_data( 'void_records', $this->Consumable_request_model->get_list(STATUS_VOID) );
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
				
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} = $value;
				}
				$record->date = db_date($this->input->post('request_date'));
				if(!$id) { $record->added_by = $this->session->userdata('user_id'); }
				$inserted_result = $record->save();
				if ( $inserted_request_id = $id? $id: $inserted_result ) {
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
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'] ) );
				}
			}
		}
		$this->load->view('consumables_request/form',$this->get_data());
	}

	function validate_form($id)
	{
       	$this->form_validation->set_rules('data[property_id]','Property','required');
       	$this->form_validation->set_rules('data[po_no]','PO No.','required');
       	$this->form_validation->set_rules('data[status]','Status','required');
       	$this->form_validation->set_rules('data[request_by]','Request By','required');
       	$this->form_validation->set_rules('request_date','Request Date','required');
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