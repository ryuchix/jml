<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property extends MY_Controller
{
	private $gallery_path = './uploads/gallery/';
	private $gellary_upload_error = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Property_model', 
				'Client_model', 
				'Contacts_model', 
				'Service_model', 
				'Property_services_model', 
				'Property_keys_model', 
				'Key_type_model',
				'Gallery_model',
				'Property_bins_model',
				'Council_model',
				'Gallery_images_model'
			));
		$this->set_data('active_menu', 'property');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'property';
	}

	function index($disable = false, $modified_item_id=0)
	{
		$this->redirectIfNotAllowed('view-property');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		
		$this->set_data( 'sub_menu', 'view_property');
		
		$sql = "SELECT p.*, c.name FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE p.active = ";
		$this->set_data( 'records', $this->db->query($sql."1")->result() );
    	$this->set_data( 'inactive_records', $this->db->query($sql."0")->result() );

		$this->load->view('properties/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-property': 'add-property', 'property');

		$record = new Property_model();
		$this->set_data( 'selected_services', array() );
		
		if ($id) {
			$record->load($id);
			// dd($record);
			$this->set_data( 'selected_services', $this->Property_services_model->get_dropdown_lists_by_property_id($record->id) );
		}else{
			$this->set_data('sub_menu', 'add_property');
		}

		if(isset($_GET['client']) && is_numeric($_GET['client'])){
			$c = new Client_model();
			$c->load($_GET['client']);
			$this->set_data('client_name', " ( for $c->name )");
			$this->set_data('get_link', "?client=$c->id");
		}else{
			$this->set_data('client_name', '');
			$this->set_data('get_link', '');
		}

		$this->set_data('record', $record);
		$this->load->library('form_validation');
		$this->set_data( 'clients', $this->Client_model->get_dropdown_lists() );
		$this->set_data( 'services', $this->Service_model->get_dropdown_lists(false) );
		$this->set_data( 'councils', $this->Council_model->get_dropdown_lists(1) );

		$this->set_data( 'contacts', [] );

		if( isset($_POST['submit']) ){
			
			$this->set_conditional_validation_roles($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} = $value;
				}
				$record->active = $id? $record->active: 1;
				$record->allow_contractors = $this->input->post('allow_contractors')? 1: 0;
				$inserted_result = $record->save();

				if ( $inserted_property_id = $id? $id: $inserted_result ) {
					$this->Property_services_model->deleteWhere(array('property_id'=>$inserted_property_id));
					foreach ($this->input->post('services') as $service_id) {
						$property_services = new Property_services_model();
						$property_services->service_id = $service_id;
						$property_services->property_id = $inserted_property_id;
						$property_services->save();
					}

					if (!$id) { 
						$this->add_history($inserted_property_id, "Properties added ");
					}else{
						$this->add_history($inserted_property_id, "Properties Upldated ");
					}
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name'] ) );
				}
			}
		}
		$this->load->view('properties/form',$this->get_data());
	}

	function get_client_contact()
	{
		if (isset($_POST['client_id'])) {
			$contacts = $this->Contacts_model->get_dropdown_lists($_POST['client_id']);
			echo json_encode($contacts);
		}
	}

	function set_conditional_validation_roles($id)
	{
       	$this->form_validation->set_rules('data[client_id]','Client','required');
       	$this->form_validation->set_rules('data[contact_id]','Contact','required');
    	$this->form_validation->set_rules('data[address]','Address','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_state]','State','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_suburb]','Suburb','required|max_length[255]');
    	$this->form_validation->set_rules('data[address_post_code]','Suburb','required');
    	$this->form_validation->set_rules('services[]','Services','required');
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-property-status', 'property');
		$record = new Property_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			$this->add_history($id, "Property activated");
			set_flash_message(0, 'Supplier status changed to active');
			redirect( site_url( $this->data['class_name'].'/index/0/'.$id ) );
		}else{
			$this->add_history($id, "Property inactivated");
			set_flash_message(0, 'Supplier status changed to inactive');
			redirect( site_url( $this->data['class_name'].'/index/1/'.$id ) );
		}
	}

	function map($id){
		$record = new Property_model();
		$record->load($id);
		$this->set_data('record', $record);
		$this->load->view('properties/map', $this->get_data());
	}

	function keys($property_id, $action, $property_key_id=0)
	{
		switch ($action) {
			case 'save':
				$this->save_keys($property_id, $property_key_id);
				break;
			
			case 'lists':
				$this->keys_list($property_id, $disable = false, $modified_item_id=0);
				break;
		}
	}

	function key_photo($id)
	{
		$key = new Property_keys_model();
		$key->load($id);
		echo "<img class='img-responsive img-thumbnail' src='".base_url("uploads/property_keys/$key->image")."' />";
	}

    function keys_list($property_id, $disable, $modified_item_id)
    {
    	$this->redirectIfNotAllowed('view-property-key','property');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		
    	$this->set_data('property_id', $property_id);
    	$sql = "SELECT k.id AS id, kt.type AS type, k.description, k.internal_reference, k.property_id, k.active, k.image FROM property_keys AS k 
    			JOIN key_type AS kt ON k.key_type_id = kt.id WHERE k.property_id = $property_id AND k.active = ";
    	$this->set_data( 'records', $this->db->query( $sql."1" )->result() );
    	$this->set_data( 'inactive_records', $this->db->query( $sql."0" )->result() );
		$this->load->view('properties/lists_keys', $this->get_data());
    }

	function save_keys($property_id, $property_key_id)
	{
    	$this->redirectIfNotAllowed($property_key_id? 'edit-property-key': 'add-property-key', "property/keys/$property_id/lists");

		$this->set_data('property_id', $property_id);

		$this->load->library('form_validation');

		$this->set_data('expected_id', 'Key-'.$this->Property_keys_model->max());

		$record = new Property_keys_model();

		if ($property_key_id) { $record->load($property_key_id); }

		$this->set_data('record', $record);

    	$this->set_data('key_types', $this->get_key_types());

		if (isset($_POST['submit'])) 
		{
			foreach ($this->input->post('data') as $key => $value) 
			{
				$record->{$key} = $value;
			}
			$record->property_id = $property_id;
			$record->active = $record->id? $record->active: 1;
			$record->{$record->id?'updated_by':'added_by'} = $this->session->userdata('user_id');
			if ($record->save()) {
				$this->add_history($property_id, $property_key_id? "Key Updated":"Key Added");
				set_flash_message(0, $property_key_id? "Key Updated Successfully":"Key Added Successfully");
				redirect( site_url( "property/keys/$property_id/lists" ) );
			}else{
				set_flash_message(1, "No changes made!");
			}
		}
    	$this->load->view('properties/key_form', $this->get_data());
	}

	function key_activation($id, $boolean=false)
	{
		$record = new Property_keys_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			$this->add_history($id, "Property key activated");
			set_flash_message(0, 'Key changed to active');
			redirect( site_url( "property/keys_list/$record->property_id/0/$record->id" ) );
		}else{
			$this->add_history($id, "Property key inactivated");
			set_flash_message(0, 'Key changed to inactive');
			redirect( site_url( "property/keys_list/$record->property_id/1/$record->id" ) );
		}
	}

    function get_key_types()
    {
    	$this->load->model('Key_type_model');
    	return array_map(
					function($o){ 
						return $o->type; 
					}, 
					$this->Key_type_model->getWhere(array('active'=>1))
				); // array_map
    }

	/********************************** Bins Actions ************************************/

	function bins($property_id, $action, $bin_id=0)
	{
		switch ($action) {
			case 'save':
				$this->save_bins($property_id, $bin_id);
				break;
			
			case 'lists':
				$this->bins_list($property_id, $disable = false, $modified_item_id=0);
				break;
		}
	}

	function save_bins($property_id, $property_bin_id)
	{
		$this->redirectIfNotAllowed($property_bin_id? 'edit-property-bin': 'add-property-bin',"property/$property_id/lists");

		$this->set_data('property_id', $property_id);
		
		$this->load->library('form_validation');
		
		$record = new Property_bins_model();
		if ($property_bin_id) { $record->load($property_bin_id); }
		$this->set_data('record', $record);
    	$this->set_data('bin_types', $this->get_bin_types());

		if (isset($_POST['submit'])) {

       		$this->form_validation->set_rules('data[bin_type]','Bin type','required');
       		$this->form_validation->set_rules('data[qty]','Quantity','required|numeric');

			if ( $this->form_validation->run() == TRUE ) {

				foreach ($this->input->post('data') as $key => $value) {
					$record->{$key} = $value;
				}

				$record->property_id = $property_id;
				$record->active = $record->id? $record->active: 1;
				$record->{$record->id?'updated_by':'added_by'} = $this->session->userdata('user_id');
				if ($record->save()) {
					$this->add_history($property_id, $property_bin_id? "Bin Updated":"Bin Added");
					set_flash_message(0, $property_bin_id? "Bin Updated Successfully":"Bin Added Successfully");
					redirect( site_url( "property/bins/$property_id/lists" ) );
				}
			}
		}
    	$this->load->view('properties/bin_form', $this->get_data());
	}

    function get_bin_types()
    {
    	$this->load->model('Bin_type_model');
    	return $this->Bin_type_model->getWhere(array('active'=>1));
    	return array_map(
					function($o){ 
						return "$o->type - $o->color <div style='background: red height: 10px; width: 30px;'></div>";
					}, 
					$this->Bin_type_model->getWhere(array('active'=>1))
				); // array_map
    }

    function bins_list($property_id, $disable, $modified_item_id)
    {
    	$this->redirectIfNotAllowed('view-property-bin', "property");
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		
    	$this->set_data('property_id', $property_id);
    	$sql = "SELECT b.id AS id, bt.type AS type, bt.size, b.notes, bt.color, b.property_id, b.active, b.qty FROM property_bins AS b 
    			JOIN bin_type AS bt ON b.bin_type = bt.id WHERE b.property_id = $property_id AND b.active = ";
    	$this->set_data( 'records', $this->db->query( $sql."1" )->result() );
    	$this->set_data( 'inactive_records', $this->db->query( $sql."0" )->result() );
		$this->load->view('properties/lists_bins', $this->get_data());
    }

	function bin_activation($id, $boolean=false)
	{
		$record = new Property_bins_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			$this->add_history($id, "Property Bin activated");
			set_flash_message(0, 'Key changed to active');
			redirect( site_url( "property/bins_list/$record->property_id/0/$record->id" ) );
		}else{
			$this->add_history($id, "Property Bin inactivated");
			set_flash_message(0, 'Key changed to inactive');
			redirect( site_url( "property/bins_list/$record->property_id/1/$record->id" ) );
		}
	}

	/********************************** Consumables Actions ************************************/

	function consumables($property_id, $action, $consumable_id=0)
	{
		switch ($action) {
			case 'save':
				$this->save_consumable($property_id, $consumable_id);
				break;
			
			case 'lists':
				$this->consumables_list($property_id, $disable = false, $modified_item_id=0);
				break;
		}
	}

	function save_consumable($property_id, $property_consumable_id)
	{
		$this->set_data('property_id', $property_id);
		$this->load->library('form_validation');
		$this->load->model(array('Consumable_model','Property_consumables_model'));
		
		$record = new Property_consumables_model();
		$consumable = new Consumable_model();
		$this->set_data('cons', $consumable);

		if ($property_consumable_id) { 
			$record->load($property_consumable_id);
			$consumable->load($record->consumable_id);
			$this->set_data('cons', $consumable);
		}
		$this->set_data('record', $record);
		

    	$this->set_data('consumables', $this->Consumable_model->get_dropdown_lists(true, 1, $property_id));

		if (isset($_POST['submit'])) {

       		$this->form_validation->set_rules('data[consumable_id]','Consumable','required');
       		$this->form_validation->set_rules('data[markup]','Markup','required');
       		$this->form_validation->set_rules('data[soled_price_per_box]','Soled Price Per Box','required');
       		$this->form_validation->set_rules('data[soled_price_per_unit]','Soled Price Per Unit','required');

			if ( $this->form_validation->run() == TRUE ) {

				foreach ($this->input->post('data') as $key => $value) {
					$record->{$key} = $value;
				}
				$record->property_id = $property_id;
				if ($record->save()) {
					$this->add_history($property_id, $property_consumable_id? "Property Consumable Updated":"Property Consumable Added");
					set_flash_message(0, $property_consumable_id? "Property Consumable Updated Successfully":"Property Consumable Added Successfully");
					redirect( site_url( "property/consumables/$property_id/lists" ) );
				}
			}
		}
    	$this->load->view('properties/consumable_form', $this->get_data());
	}

    function consumables_list($property_id, $disable, $modified_item_id)
    {
    	$this->set_data('property_id', $property_id);
    	$property = new Property_model();
    	$property->load($property_id);
    	$this->set_data('property', $property);
    	
    	$sql = "SELECT pc.id AS id, c.name, pc.soled_price_per_unit, pc.soled_price_per_box 
    			FROM property_consumables AS pc 
    			JOIN consumable AS c ON c.id = pc.consumable_id WHERE pc.property_id = $property_id";
    	$this->set_data( 'records', $this->db->query( $sql )->result() );
		$this->load->view('properties/lists_consumables', $this->get_data());
    }

    function delete_property_consumable($id=false)
    {
		$this->load->model(array('Property_consumables_model'));
    	$record = new Property_consumables_model();
    	$record->load($id);
    	if (!$id || !$record->id) {
    		set_flash_message(2, "No Record Found!");
    		redirect( site_url('property/') );
    	}

    	if ($record->delete()) {
    		set_flash_message(0, "Property Consumable Deleted Successfully!");
			$this->add_history($record->property_id, "Property Consumable Removed");
    		redirect( site_url("property/consumables/$record->property_id/lists") );
    	}

    }

    function history($id)
    {
        $this->load->library('form_validation');

        $this->set_data('property_id', $id);

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('description','Description','required');
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

        $this->load->view('properties/history', $this->get_data());
    }

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8