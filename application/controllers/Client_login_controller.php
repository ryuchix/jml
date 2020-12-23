<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Client_login_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Client_model']);
        $this->set_data('active_menu', 'client');
    }

    /* User Default Method for the controller */
    function index($disable = false, $modified_item_id=0)
    {

    }

    /* Logging in users to the system */
    function login()
    {
    	$this->load->library('form_validation');

    	if ( isset( $_POST['submit'] ) ) 
        {
    		if( $this->form_validation->run('login') == TRUE )
            {
	    		$username = $this->input->post('username');
	    		$password = $this->input->post('password');
	    		$found = $this->Client_model->authenticate($username, $password);

	    		if (!$found) 
                {
                    $this->set_data('flash_message', 'Username/Password Invalid!');
                    $this->load->view( 'clients/login', $this->get_data() );
                    return;
                }

    			$this->session->set_userdata('logged_in',true);
                $this->session->set_userdata('user_id', $found->id);
                $this->session->set_userdata('user_role', $found->user_role);
                $this->session->set_userdata('fullname', $found->first_name . ' ' .$found->last_name);
                $this->session->set_userdata('username', $found->user_name);
                $this->session->set_userdata('dp', $found->image);
                $this->session->set_userdata('email', $found->email);
                $this->session->set_userdata('is_client', true);

                if ( isset( $_GET['redirect']) ) 
                {
                    redirect(site_url($_GET['redirect']));
                }else{
                    redirect( site_url('clients/dashboard') );
                }

    		} // if form validation passes

    	}

    	$this->load->view( 'clients/login', $this->get_data() );

    } // end login function

    /* Logging out the user from the system */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('clients/login'));
    } // end logout function

} // end user class