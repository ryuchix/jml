<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_balances extends MY_Controller
{
	private $validation_state = array();

	private $validation_message = array();

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Daily_balance_model');
		$this->set_data('active_menu', 'daily_balance');
	}


	function index($modified_item_id = 0)
	{
		$this->set_data('sub_menu', 'view_daily_balance');
		
		$this->set_data( 'records', $this->Daily_balance_model->get() );

		$this->load->view('daily_balances/lists', $this->get_data());
	}

	function save($id=false)
	{

		$this->set_data('sub_menu', 'add_daily_balance');
		
		$record = new Daily_balance_model();

		if ($id) { $record->load($id); }

		$this->set_data('record', $record);
 
		if( !isset($_POST['submit']) ){
			$this->load->view('daily_balances/form',$this->get_data());
			return;
		}

		$this->validate_fields($id);

		if ( $this->form_validation->run() == FALSE ) {

			$this->load->view('daily_balances/form',$this->get_data());

			return;

		}

		$record->date = db_date($this->input->post('data[date]'));

		$record->balance = $this->input->post('data[balance]');

		$record->notes = $this->input->post('data[notes]');

		$record->{$id? 'updated_by':'created_by'} = $this->session->userdata('user_id');

		$result = $record->save();

		if( !$result == $id )
			set_flash_message(1, "No changes made!");

		if( $result )
			set_flash_message(0, "Record Submitted Successfully!");

		redirect( site_url( 'daily_balances/' ) );
		
		$this->load->view('daily_balances/form',$this->get_data());

	}


	function validate_fields($id)
	{

   		$this->form_validation->set_rules('data[date]','Date', 'required');

   		$this->form_validation->set_rules('data[balance]','Balance', 'required|numeric');

	}

	public function get_progress()
	{

		$balances = $this->Daily_balance_model->get_progress();

		$data = [];
		
		foreach ($balances as $balance) {

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