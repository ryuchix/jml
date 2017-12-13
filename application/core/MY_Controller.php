<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 *
 */
class MY_Controller extends CI_Controller
{

    public $data = array('active_menu'=>'','sub_menu'=>'', 'page_title'=>'Dashboard', 'styles'=>array(), 'scripts'=>array());
    public $history_context;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('History_model');
        $allowed_urls = array('login','reset_email_password','reset_password');

        if ( !$this->session->userdata('logged_in') && !in_array($this->router->method, $allowed_urls)){
            $url = $this->router->uri->uri_string;
            redirect(site_url('users/login?redirect='.$url));
        }

    } // __construct

    function set_data($key, $value){
        $this->data[$key] = $value;
    }

    function get_data(){
        return $this->data;
    }

    function add_history($id, $description)
    {   
        $history = new History_model();
        $history->description = $description;
        $history->context_id = $id;
        $history->context = $this->context;
        $history->action_by = $this->session->userdata('user_id');
        $history->save();
    }

} // MY_Controller