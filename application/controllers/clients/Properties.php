<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array( 
			'Client_model', 
			'Property_model', 
		));
	}

	public function index()
	{
        if(!$this->session->userdata('is_client'))
        {
            redirect('/clients/dashboard');
        }
        
        $this->set_data('records', $this->getClients());

		$this->load->view('properties/lists', $this->get_data());
    }
    
    protected function getClients()
    {
        $client_id = $this->session->userdata('user_id');

        $client = new Client_model();
        $client->load($client_id);

        if($client->is_parent)
        {
		    $sql = "SELECT p.*, c.name FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE c.active = ";

        }

		$sql = "SELECT p.*, c.name FROM property AS p JOIN client AS c ON c.id = p.client_id WHERE p.active = ";
		$this->set_data( 'records', $this->db->query($sql."1")->result() );
        $this->set_data( 'inactive_records', $this->db->query($sql."0")->result() );
        
        dd($client);
    }
}
