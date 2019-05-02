<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BinCleaningCostingController extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Daily_balance_model');
		$this->set_data('active_menu', 'bin_cleaning_costing');
	}

	function index()
	{
		$this->set_data('sub_menu', 'view_bin_cleaning_costing');
		$this->set_data( 'records', BinCleaningCosting::all() );
		$this->load->view('bin_cleaning_costing/lists', $this->get_data());
	}

	function create()
	{
		$this->set_data('sub_menu', 'add_bin_cleaning_costing');
		$this->set_data('costing', new BinCleaningCosting);		
		$this->load->view('bin_cleaning_costing/create', $this->get_data());
	}

	function store()
	{
        $_POST = json_decode(file_get_contents("php://input"), true);
		
		$this->validate_fields();

		if ( $this->form_validation->run() == FALSE ) 
			return $this->sendResponse($this->form_validation->error_array(), 422);

		$user = User::find($this->session->get_userdata('user_id'))->first();

		$user->bin_cleaning_costings()->save(new BinCleaningCosting($_POST));

		return $this->sendResponse($costing, 201);		
	}

	public function edit($id)
	{
		$costing = BinCleaningCosting::find($id);

		if(!$costing)
		{
			set_flash_message(2, "No record found!");
			redirect('bin-cleaning-costing');
		}
		$this->set_data('sub_menu', 'add_bin_cleaning_costing');
		$this->set_data('costing', $costing);
		$this->load->view('bin_cleaning_costing/create', $this->get_data());
	}

	function update($id)
	{
        $_POST = json_decode(file_get_contents("php://input"), true);
		$this->validate_fields();

		if ( $this->form_validation->run() == FALSE ) 
			return $this->sendResponse($this->form_validation->error_array(), 422);

		$costing = BinCleaningCosting::find($id);

		$costing->fill($_POST);

		$costing->save();

		return $this->sendResponse($costing, 201);		
	}

	function destroy($id)
	{
		$costing = BinCleaningCosting::find($id);
		$costing->delete();
		set_flash_message(0, "Record deleted Successfully!");
		redirect('bin-cleaning-costing');
	}

	function validate_fields()
	{
   		$this->form_validation->set_rules('cost_title','Cost Title', 'required');
   		$this->form_validation->set_rules('monthly_cost','Monthly Cost', 'required|numeric');
   		$this->form_validation->set_rules('daily_cost','Daily Cost', 'required|numeric');
   		$this->form_validation->set_rules('notes','Notes', 'required');
	}
}