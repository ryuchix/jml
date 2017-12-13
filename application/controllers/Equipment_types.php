<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment_types extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Equipment_type_model',
			''
		]);
		$this->set_data('active_menu', 'equipments');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_equipment_type');
		
		$this->set_data( 'inactive_records', $this->Equipment_type_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Equipment_type_model->getWhere(array('active'=>1)) );
		$this->load->view('equipment_types/lists', $this->get_data());
	}

	function save($id=false){
		$this->set_data('sub_menu', 'add_equipment_type');
		$record = new Equipment_type_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

			$this->validate_fields($id);

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'equipment_types/' ) );
				}elseif ($id) {
					set_flash_message(1, "No changes made!");
				}

			}
		}
		$this->load->view('equipment_types/form',$this->get_data());
	}

	function validate_fields($id)
	{
   		if ($id) { 
   			$this->form_validation->set_rules('data[type]','Equipment Type','required|callback_custom_type_check['.$id.']');
   		}else{
   			$this->form_validation->set_rules('data[type]','Equipment Type','required');
   		}
	}

	function activation($id, $boolean=false)
	{
		$record = new Equipment_type_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Equipment Type status changed to active');
			redirect( site_url( 'equipment_types/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Equipment Type status changed to inactive');
			redirect( site_url( 'equipment_types/index/1/'.$id ) );
		}
	}

    public function custom_type_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('equipment_type');
        if($users->row()){
            $this->form_validation->set_message('custom_type_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}