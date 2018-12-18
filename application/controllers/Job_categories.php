<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_categories extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Job_category_model');
		$this->set_data('active_menu', 'jobs');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-job-categories');
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_job_categories');
		
		$this->set_data( 'inactive_records', $this->Job_category_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Job_category_model->getWhere(array('active'=>1)) );
		$this->load->view('job_categories/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed($id? 'edit-job-category': 'add-job-category', 'job_categories');

		$this->set_data('sub_menu', 'add_job_category');

		$record = new Job_category_model();

		if ($id) 
		{
			$record->load($id);
		}

		$this->set_data('record', $record);

		$this->load->library('form_validation');

		if( isset($_POST['submit']) )
		{

       		if ($id) {
       			$this->form_validation->set_rules('data[type]','Job Category','required|callback_custom_job_categories_check['.$id.']');
       		}else{
       			$this->form_validation->set_rules('data[type]','Job Category','required|is_unique[job_categories.type]');
       		}

			if ( $this->form_validation->run() == FALSE ) 
			{
				$this->load->view('job_categories/form',$this->get_data());
				return;
			}

			foreach ($this->input->post('data') as $field => $value) {
				$record->{$field} 	= $value;
			}

			$record->{$id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

			if ($record->save()) {
				set_flash_message(0, "Record Submitted Successfully!");
				redirect( site_url( 'job_categories/' ) );
			}
		}

		$this->load->view('job_categories/form',$this->get_data());
	}

	function activation($id, $boolean=false)
	{
		$this->redirectIfNotAllowed('change-lead-type-status');
		$record = new Job_category_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Job Category status changed to active');
			redirect( site_url( 'job_categories/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Job Category status changed to inactive');
			redirect( site_url( 'job_categories/index/1/'.$id ) );
		}
	}

    public function custom_job_categories_check($name,$id){
        $this->db->where('type',$name);
        $this->db->where('id !=',$id);
        $users = $this->db->get('job_categories');
        if($users->row()){
            $this->form_validation->set_message('custom_job_categories_check', 'The {field} must be unique. This is already in use.');
            return false;
        }else{
            return true;
        }
    }

}