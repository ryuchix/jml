<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_consumable_equipment extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Equipment_type_model',
			'Property_consumable_equipment_type_model',
			'Property_consumable_item_model',
			'Property_model',
            'Consumable_model'
		]);
		$this->set_data('active_menu', 'property');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function save($property_id){
		$this->set_data('sub_menu', 'add_equipment_tag');
		$this->set_data('property_id', $property_id);

		$this->set_data('equipment_types_ids', 
				$this->Property_consumable_equipment_type_model->get_equipment_type_ids_by_property_id($property_id));
		$this->set_data('consumables_ids', 
				$this->Property_consumable_item_model->get_consumable_ids_by_property_id($property_id));

        $property = new Property_model();
        $property->load($property_id);

        $this->set_data( 'property', $property );

        $this->set_data('equipment_types', $this->Equipment_type_model->get());
		$this->set_data('consumables', $this->Consumable_model->get());

		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			$this->Property_consumable_equipment_type_model->deleteWhere(['property_id'=>$this->input->post('data[property_id]')]);
			$this->Property_consumable_item_model->deleteWhere(['property_id'=>$this->input->post('data[property_id]')]);
			
			if($this->input->post('consumables')){
				foreach ($this->input->post('consumables') as $consumable_id) {
					$x = new Property_consumable_item_model();
					$x->property_id 	= $this->input->post('data[property_id]');
					$x->consumable_id 	= $consumable_id;
					$x->save(true);
				}
			}
			if($this->input->post('equipment_types')){
				foreach ($this->input->post('equipment_types') as $equipment_type_id) {
					$x = new Property_consumable_equipment_type_model();
					$x->property_id 		= $this->input->post('data[property_id]');
					$x->equipment_type_id 	= $equipment_type_id;
					$x->save(true);
				}
			}
			set_flash_message(0, "Record Submitted Successfully!");
			redirect( site_url( "property_consumable_equipment/save/$property_id" ) );
		}
		$this->load->view('property_consumable_equipments/form', $this->get_data());
	}

	function validate_fields($id)
	{
   		$this->form_validation->set_rules('data[property_id]','Property','required');
        $this->form_validation->set_rules('consumables[]','Consumable','required');
   		$this->form_validation->set_rules('equipment_types[]','Equipment Type','required');
	}



}