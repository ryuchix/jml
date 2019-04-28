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

	public function binCleaning()
	{
        $this->load->view('schedules/bin_cleaning', $this->get_data());
    }

	public function binCleaningFilter()
	{
        $post = json_decode(file_get_contents("php://input"), true);

        $post['fromDate'] = (DateTime::createFromFormat('d/m/Y', $post['fromDate']))->format('Y-m-d');
        $post['toDate'] = (DateTime::createFromFormat('d/m/Y', $post['toDate']))->format('Y-m-d');

        $dateChunks = $this->getDateChunks($post['fromDate'], $post['toDate']);

        $jobs = $this->getJobs($post);

        return $this->sendResponse(['jobs' => $jobs, 'weeks' => $dateChunks]);
    }

    private function getDateChunks($fromDate, $toDate)
    {
        $startDate = new DateTime($fromDate);
        $endDate = new DateTime($toDate);
        
        $dateChunks = [];
        $week = null;
        $weekStartDate = new DateTime($startDate->format('Y-m-d'));
        $weekEndDate = null;

        while($startDate <= $endDate){
            // Get day name for later conditions
            $day = $startDate->format('D');

            // if($week && $day === "Mon" && count($week) == 5) $week = [];

            // assign week's last date so that we can make title relavent to the week start and end date
            if($day === 'Fri') $weekEndDate = (new DateTime($startDate->format('Y-m-d')));
            
            // assign week's First date so that we can make title relavent to the week start and end date
            if($day === 'Mon') $weekStartDate = (new DateTime($startDate->format('Y-m-d')));

            // Skip the date if it is saturday or sunday because saturday or sunday is not required in report.
            if(!in_array($day, ['Sat', 'Sun']))
                $week[] = $startDate->format('d/m/Y') . ' - ' . $day;
            
            // In any case if start date or end date is same we have to make sure the current week itration is end right away
            // Because users are free to choose any date from the calendar
            if($startDate == $endDate) $weekEndDate = $endDate;
            
            // Push week to WeekChunk if Day is monday and also we have five in dates in week array
            // OR
            // Push week to weekChunck in case the start date or end date is same because
            if($startDate == $endDate || ($day === "Fri"))
            {
                // get Week title based on week start and end dates.
                $title = $this->getWeekTitle($weekStartDate, $weekEndDate);
                $dateChunks[$title] = $week;
            };

            // Reset $week Array after pushing to chumk of weeks on every monday
            if($day == 'Fri')
                $week = [];

            // Increment a day after every condition.
            $startDate->modify('+1 day');
        };

        return $dateChunks;
    }

    private function getJobs($post)
    {
        $jobsQuery = Job::whereHas('category', function($q){ 
            $q->whereIn('id', JobCategory::whereIn('type', ['Bin Cleaning', 'Bin Cleaning - Residential'])->select('id')->get()); 
        })->whereHas('client', function($q) use($post){
            $q->where('active', (int)$post['status']);
            if($post['clientType']) $q->where('client_type', $post['clientType']);
            
            if($post['suburb'])
            {
                $q->where('address_suburb', $post['suburb']);
            }
        })->with(['category' => function($q){
            $q->select('id', 'type');
        }, 'client' => function($q){
            $q->select('id', 'name', 'address_1', 'active', 'address_suburb', 'client_type');
            $q->with(['type' => function($q){ $q->select('id', 'type as name'); }]);
        }, 'visits' => function($q) use($post){
            $q->whereBetween('date', [$post['fromDate'], $post['toDate']]);
            // $q->select('id', 'name', 'address_1', 'address_suburb', 'client_type');
            $q->with('items');
        }]);

        if(!$post['withEmpty'])
        {
            $jobsQuery->whereHas('visits', function($q) use($post){
                $q->whereHas('items', function($q) use($post){
                    $q->whereBetween('date', [$post['fromDate'], $post['toDate']]);
                });
            });
        }
        
        return $jobsQuery->get();
    }

    private function getWeekTitle($weekStartDate, $weekEndDate)
    {
        if($weekStartDate->format('M') === $weekEndDate->format('M'))
            return $weekStartDate->format('d') . ' - ' . $weekEndDate->format('d') . ' ' . $weekEndDate->format('M');
        
        return $weekStartDate->format('d') . ' ' . $weekStartDate->format('M') . ' - ' . $weekEndDate->format('d') . ' ' . $weekEndDate->format('M');
    }


}