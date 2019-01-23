<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_files extends MY_Controller
{
	private $file_path = "./uploads/job_attachments";

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Job_model', 'Job_file_model']);
		$this->set_data('active_menu', 'jobs');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function add_files($job_id)
	{
		$this->redirectIfNotAllowed('view-job');

        $job = new Job_model();
		$job->load($job_id);

        $this->set_data('job', $job);

		$this->set_data('sub_menu', 'view_jobs');

		$this->load->view('jobs/add_files', $this->get_data());
    }

	function get_files($job_id)
	{
        $files = $this->Job_file_model->getWhere(['job_id' => $job_id]);
        return $this->output
                ->set_status_header(201)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'files' => $files]));
    }
    
    public function file_upload($job_id)
    {
		$this->redirectIfNotAllowed('view-job');

        $job = new Job_model();
		$job->load($job_id);

        $this->load->library('upload');
        $config = array(
            'allowed_types' => 'jpg|jpeg|png|gif|pdf|doc|docx',
            'overwrite'     => FALSE,
            'upload_path' => "./uploads/job_attachments"
        );
        
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        // var_dump($_FILES['file']);

        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('file') ) :
            $error = array('error' => $this->upload->display_errors());
            return $this->output
                        ->set_status_header(401)
                        ->set_content_type('application/json')
                        ->set_output(json_encode($error));
        else :
            $data = $this->upload->data();
            $file = new Job_file_model();
            $file->job_id = $job_id;
            $file->name = $data['file_name'];
            $file->size = $data['file_size'];
            $file->created_by = $this->session->userdata('user_id');
            $file->save();
            return $this->output
                        ->set_status_header(201)
                        ->set_content_type('application/json')
                        ->set_output(json_encode(['status' => true, 'file' => $file]));
        endif;

    }

}