<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('User_model'));

		// if ( !isset( $_POST['auth'] ) || $_POST['auth'] !== 'ABCD' ) {
  //   		$this->output
	 //            ->set_content_type('application/json')
		//             ->set_output(json_encode(array('error'=>true, 'message'=>'Invalid Auth Key')));
  //   	}

	}

	function login(){
    	
    	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
    		$username = $this->input->post('username');
    		$password = $this->input->post('password');
    		$found = $this->User_model->authenticate($username, $password);
    		if ($found) {
                $this->response(json_encode($found));
            }else{
                $this->response('', 401, 'Username/Password Invalid!');
            }
        }else{
    		$this->response('', 404, 'Page Not Found.');
    	}

    } // end login function

    function get_users()
    {
    	$user = new User_model();
    	$user->load(1);
		$this->output
	            ->set_content_type('application/json')
		            ->set_output(json_encode($user));

    }

    function get_header()
    {
    	$this->output
	            ->set_content_type('application/json')
		            ->set_output(json_encode($_SERVER));
    }

    function response($response, $status=200, $message='')
    {
        $this->output
        ->set_status_header($status, $message)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

}