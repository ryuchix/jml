<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuickbookAPI extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['User_model','Service_model']);
        $this->set_data('active_menu', 'users');
    }

    /* User Default Method for the controller */
    function index(){

        
        $services = $this->Service_model->get_all_services();

        // $this->Service_model->createService();
                
        x($services[0]);

    } // index


} // end QuickbookAPI class