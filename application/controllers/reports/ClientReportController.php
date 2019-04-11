<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientReportController extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'Client_model', 
			'Client_type_model', 
			'Lead_type_model', 
		));

		$this->set_data('active_menu', 'reports');
	}

	function index()
	{
		
	}

	public function filters()
	{
		$this->redirectIfNotAllowed('client-report');

		$this->set_data('clients_or_prospects', array('All', 'Client', 'Prospect', 'Lead')[$this->input->get('client_or_prospect')? $this->input->get('client_or_prospect'): 0 ]);

		if (isset($_GET['client_or_prospect']) && isset($_GET['lead_type']) && isset($_GET['client_type'])) 
		{
			$this->set_data('records', $this->Client_model->get_filtered_list());
		}else{
			$this->set_data('records', []);
		}

		if (isset($_GET['export']) and $_GET['export'] == 'csv') 
		{
			$this->exportAsCsv();
			return;
		}
		
		$this->load->library('form_validation');

		$this->set_data('lead_types', $this->Lead_type_model->dropdown_list('All'));
		
		$this->set_data('client_types', $this->Client_type_model->dropdown_list('All'));

		$this->load->view( 'reports/clients/filters', $this->get_data() );
	}

	protected function exportAsCsv()
	{
		$data = $this->data['records'];

   		$this->load->library('FilteredClientCsvExport');

   		$csv = new FilteredClientCsvExport('Client_model');

   		$csv->excludeColumns(['client_type_id', 'lead_type_id']);

   		$csv->setData($data);

   		$csv->export();
	}

}