<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
    public $data = array(
        'active_menu'=>'',
        'sub_menu'=>'', 
        'page_title'=>'Dashboard', 
        'styles'=>array(), 
        'scripts'=>array(), 
        'roles'=>array()
    );

    public $history_context;

    public $notPermittedMessage = 'You are not permitted for this operation.';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['History_model', 'User_model']);
        $allowed_urls = array('login','reset_email_password','reset_password');

        if ( !$this->session->userdata('logged_in') && !in_array($this->router->method, $allowed_urls)){
            $url = $this->router->uri->uri_string;
            redirect(site_url('users/login?redirect='.$url));
        }

        $authenticatedUser = new User_model();
        $authenticatedUser->load($this->session->userdata('user_id'));
        $this->set_data('roles', $authenticatedUser->getAllowedPermissions());
        $this->set_data('controller', $this);


        // $authenticatedUser = new User_model();
        // $authenticatedUser->load(16);
        // echo "<pre>";
        // $this->set_data('roles', $authenticatedUser->getAllowedPermissions());
        // print_r($this->data['roles']);
        // echo "</pre>";

    } // __construct

    public function hasAccess($names)
    {
        if(is_array($names))
        {

            foreach ($names as $name) 
            {
                if( in_array($name, $this->data['roles']) )
                {
                    return true;
                }
            }

        }

        return in_array($names, $this->data['roles']);
    }

    public function redirectIfNotAllowed($permissionName, $url = '')
    {
        if ( ! $this->hasAccess($permissionName) )
        {
            set_flash_message(2, "Sorry you are not permitted for this Action");
            redirect( site_url($url) );
        }
    }

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

    protected function sendResponse($data, $status=200)
    {
        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

} // MY_Controller