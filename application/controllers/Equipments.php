<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipments extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Equipment_model',
			'Equipment_type_model',
			'Supplier_model',
			'User_model'
		]);
		$this->set_data('active_menu', 'equipments');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_equipment');
		
		$this->set_data( 'inactive_records', $this->Equipment_model->get_list(0) );
		$this->set_data( 'records', $this->Equipment_model->get_list() );
		$this->load->view('equipments/lists', $this->get_data());
	}

	function save($id=false){
		$this->set_data('sub_menu', 'add_equipment');
		$record = new Equipment_model();
		if ($id) { $record->load($id); }

		$this->set_data('record', $record);
		$this->set_data('equipment_types', $this->Equipment_type_model->get_dropdown_lists());
		$this->set_data('suppliers', $this->Supplier_model->get_dropdown_lists());
		$this->set_data('users', $this->User_model->get_dropdown_lists());
		// $this->set_data('users', $this->Users_model->get_dropdown_lists());
		
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){

       		$this->validate_fields($id);

			if ( $this->form_validation->run('add_document_type') == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->purchased_date = db_date($this->input->post('purchased_date'));
				$record->active = $id? $record->active: 1;

				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'equipments/' ) );
				}

			}
		}
		$this->load->view('equipments/form', $this->get_data());
	}

	function validate_fields($id)
	{
		if ($id) {  }
   		$this->form_validation->set_rules('data[equipment_type_id]','Equipment type','required');
   		$this->form_validation->set_rules('data[name]','Equipment name','required');
   		$this->form_validation->set_rules('data[serial_no]','Serial no.','required');
   		$this->form_validation->set_rules('data[supplier_id]','Supplier','required');
   		$this->form_validation->set_rules('purchased_date','Purchased date','required');
   		$this->form_validation->set_rules('data[initial_cost]','Initial cost','required|numeric');
	}

	function activation($id, $boolean=false)
	{
		$record = new Equipment_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Equipment status changed to active');
			redirect( site_url( 'equipments/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Equipment status changed to inactive');
			redirect( site_url( 'equipments/index/1/'.$id ) );
		}
	}

	function view($id)
	{
		if (!$id) {
			$this->load->library('Fpdf');
			$pdf = new FPDF("L");
			$pdf->AddPage();
			$pdf->SetFont("Arial", "", 26);
			$pdf->Cell(0, 40, "No record found!", 0, 1, "C");
			$pdf->Output();
		}else{
			$record = $this->db->query("
				SELECT e.id, et.type, e.name, e.serial_no, e.image, e.description,
				s.name AS supplier, e.image, e.purchased_date AS date, e.initial_cost, CONCAT(u.first_name, ' ', u.last_name) AS assign
				FROM equipment AS e 
					JOIN equipment_type AS et ON et.id = e.equipment_type_id 
					JOIN supplier AS s ON s.id = e.supplier_id
					JOIN users AS u  ON u.id = e.assigned
				WHERE e.id = $id
			")->row();
			$this->load->library('Equipment_view');
			$pdf = new Equipment_view($record);
			$pdf->AddPage();
			$pdf->display_output();
			$pdf->Output();
		}
	}

}