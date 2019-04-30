<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BinCleaningCostingController extends MY_Controller
{
	private $validation_state = array();

	private $validation_message = array();

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

	function validate_fields()
	{
   		$this->form_validation->set_rules('cost_title','Cost Title', 'required');
   		$this->form_validation->set_rules('monthly_cost','Monthly Cost', 'required|numeric');
   		$this->form_validation->set_rules('daily_cost','Daily Cost', 'required|numeric');
   		$this->form_validation->set_rules('notes','Notes', 'required');
	}

	public function get_progress()
	{
		$balances = $this->Daily_balance_model->get_progress();
		$data = [];
		foreach ($balances as $balance) 
		{
			$date = DateTime::createFromFormat('Y-m-d', $balance->date);
			$data[] = [
				'y' => $date->format('d/m/y'),
				'item1' => $balance->balance
			];
		}

		return $this->output
	        ->set_status_header(200, "")
	        ->set_content_type('application/json', 'utf-8')
	        ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}