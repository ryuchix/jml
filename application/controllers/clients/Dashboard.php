<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array( 
			'Client_model', 
			'Property_model', 
			'Complain_model',
			'Quote_model',
		));
	}

	public function index()
	{
        $this->set_data('count_complaints', $this->Complain_model->count_open_or_assigned($this->session->userdata('user_id')));

        $this->set_data('count_quotes', $this->db->select('id')
					->from('quote')
                    ->where('client_id', $this->session->userdata('user_id'))
                ->count_all_results());
        
		$this->set_data('count_properties', $this->db->select('id')
					->from('property')
                    ->where('client_id', $this->session->userdata('user_id'))
				->count_all_results());
				
        $this->set_data('clietns', $this->getClients());
                
		$this->load->view('clients/dashboard/index', $this->get_data());
	}
    
    protected function getClients()
    {
        $client_id = $this->session->userdata('user_id');

        $client = new Client_model();
        $client->load($client_id);

        if($client->is_parent)
        {
		    $sql = "SELECT p.*, c.* FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE c.child_of = $client_id";
			return $this->db->query($sql)->result();
        }
        
		$sql = "SELECT p.*, c.name FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE c.id = $client_id";
		return $this->db->query($sql)->result();
    }
}
