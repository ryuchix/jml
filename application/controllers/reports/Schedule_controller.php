<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Capsule\Manager as Capsule;

class Schedule_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	public function index()
	{
        $date = isset($_GET['date'])? \Carbon\Carbon::createFromFormat('d/m/Y', $_GET['date']): \Carbon\Carbon::today();
        $staff = isset($_GET['staff'])? $_GET['staff']: false;

        $job_visits = JobVisit::whereDate('date', $date)->with(['job.property', 'crews']);

        if($staff)
        {
            $job_visits->whereHas('crews', function($q) use($staff){
                $q->where('id', $staff);
            });
        }
        $job_visits = $job_visits->get();

        $this->set_data('visits', $job_visits);
		
        // dd($job_visits, Capsule::getQueryLog());
		 
        $this->set_data('job_visits', $job_visits);

        $users = User::orderBy('first_name', 'asc')
                            ->orderBy('last_name', 'asc')
                            ->get()
                            ->pluck('full_name', 'id');

        $this->set_data('users', $users);

        // JobVisit::whereDate()->get();
        $this->load->view('schedules/list', $this->get_data());
    }

	public function map()
	{
        $date = isset($_GET['date'])? \Carbon\Carbon::createFromFormat('d/m/Y', $_GET['date']): \Carbon\Carbon::today();
        $staff = isset($_GET['staff'])? $_GET['staff']: false;

        $job_visits = JobVisit::whereDate('date', $date)->with(['job.property', 'crews', 'job.category']);

        if($staff)
        {
            $job_visits->whereHas('crews', function($q) use($staff){
                $q->where('id', $staff);
            });
        }
        $job_visits = $job_visits->get();

        /* $jobs = Job::whereHas('visits', function($q){ 
            $date = isset($_GET['date'])? $_GET['date']: \Carbon\Carbon::today();
            $staff = isset($_GET['staff'])? $_GET['staff']: false;
            $q->whereDate('date', $date);
            if($staff)
            {
                $q->whereHas('staffs', function($q) use($staff){
                    $q->where('id', $staff);
                });
            }
        })
        ->with(['property', 'crews' => function($q){
            $q->selectRaw('id, CONCAT(first_name, " ",last_name) AS name');
        }])->get(); */

        $this->set_data('visits', $job_visits);

        $users = User::orderBy('first_name', 'asc')
                            ->orderBy('last_name', 'asc')
                            ->get()
                            ->pluck('full_name', 'id');

        $this->set_data('users', $users);

        // JobVisit::whereDate()->get();
        $this->load->view('schedules/maps', $this->get_data());
    }

	public function weekly()
	{
        $this->load->view('schedules/weekly', $this->get_data());
    }

	public function weeklyPost()
	{
        $_POST = json_decode(file_get_contents("php://input"), true);
        
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        $visits = JobVisit::with(['crews' => function($q){

        }, 'job' => function($q){
            $q->select('id', 'job_title', 'job_type', 'client_id', 'job_category', 'property_id');
            $q->with(['property' => function($q){
                $q->selectRaw('id, CONCAT(address, " ", address_suburb) as address');
            }]);
        }, 'job.category' => function($q){ 
            $q->select('type', 'id'); 
        }])->whereBetween('date', [$startDate, $endDate])->get();

        return $this->sendResponse($visits->toArray());
    }
}