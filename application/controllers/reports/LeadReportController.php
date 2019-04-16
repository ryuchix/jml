<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadReportController extends MY_Controller
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
		$leads = Client::with(['clinetLogs', 'leadBy'])->where('is_lead', 1)->get();
        
        $html = $this->load->view('reports/lead_pdf_view', compact('leads'), true);

        $pdf = new Dompdf\Dompdf();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream('Properties Services.pdf', array("Attachment" => false));
	}
}