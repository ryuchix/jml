<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Task_model']);
        $this->set_data('active_menu', 'tasks');
    }

    function index($disable = false, $modified_item_id = 0)
    {
		$this->redirectIfNotAllowed('view-task');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_tasks');
		
		$this->set_data( 'inactive_records', [] );
        // $this->set_data( 'records', $this->Task_model->get() );
        $this->set_data( 'records', [] );
    	$this->load->view( 'tasks/index', $this->get_data() );
    }

    function create()
    {
        $this->set_data('record', new Task_model());
    	$this->load->view( 'tasks/create', $this->get_data() );

    }

    function store()
    {
        echo 'we are in store method.';

        // redirect(site_url('tasks/login'));

    }

    function edit($id)
    {
        echo 'we are in edit method.';

    }

    function update()
    {
        echo 'we are in udpate method.';

    }

}