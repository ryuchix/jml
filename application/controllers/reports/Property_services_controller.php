<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_services_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	public function index()
	{
        $results = $this->db->query($this->getSql())->result();

        $html = $this->load->view('reports/property_services', compact('results'), true);

        $pdf = new Dompdf\Dompdf();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream('Properties Services.pdf', array("Attachment" => false));

        
    }
    
    public function getSql(){
        return "SELECT c.name, CONCAT(p.address, ' ', p.address_state, ' ', p.address_suburb, ' ', p.address_post_code) address,
        c.attention, s.services
        FROM property p 
        JOIN client c ON c.id = p.client_id
        JOIN (SELECT ps.property_id, GROUP_CONCAT(s.name) AS services 
            FROM `property_services` AS ps
                JOIN service as s ON s.id = ps.service_id GROUP BY ps.property_id  ) s ON s.property_id = p.id
        WHERE c.active = 1
        GROUP BY p.id
        ORDER BY address ASC
        ";
    }

}