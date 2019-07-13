<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_income_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Property_model','Bin_liner_setting_model']);
		$this->load->library('form_validation');
		$this->set_data('active_menu', 'reports');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id=0, $prospect=0)
	{
		$from_date = "2019-07-06";

		$to_date = "2019-07-10";

		$date_range = getDatesInBetween($from_date, $to_date, 'Y-m-d');
		
		$jobs = Job::whereHas('visits', function($q) use($to_date, $from_date){
            $q->whereBetween('date', [$from_date, $to_date]);
        })->with(['visits' => function($q) use($to_date, $from_date){
            $q->whereBetween('date', [$from_date, $to_date])->with('items');
		}, 'property', 'client', 'category'])->get();

		

		$this->load->view('reports/daily_income/filters', $this->get_data());
	}

	public function filter()
	{
        $post = json_decode(file_get_contents("php://input"), true);

		$from_date = db_date($post['fromDate']);
		$to_date = db_date($post['toDate']);

		$date_range = getDatesInBetween($from_date, $to_date);
		$db_date_range = getDatesInBetween($from_date, $to_date, 'Y-m-d');

		$jobs = $this->getJobs($from_date, $to_date, $db_date_range);

        return $this->sendResponse(['dates' => $date_range, 'db_dates'=> $db_date_range, 'jobs' => $jobs]);
	}

	public function pdf()
	{
        $date = db_date($this->input->get('date'));
        $jobs = Job::whereHas('visits', function($q) use($date){
            $q->where('date', $date);
        })->with(['visits' => function($q) use($date){
            $q->where('date', $date)->with('items');
        }, 'property', 'client', 'category'])->get();

        $html = $this->load->view('reports/daily_income/pdf', compact('jobs'), true);
        $pdf = new Dompdf\Dompdf();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream('Daily Incomes.pdf', array("Attachment" => false));
	}

	protected function getJobs($from_date, $to_date, $db_date_range)
	{
		$jobs = Job::whereHas('visits', function($q) use($to_date, $from_date){
            $q->whereBetween('date', [$from_date, $to_date]);
        })->with(['visits' => function($q) use($to_date, $from_date){
            $q->whereBetween('date', [$from_date, $to_date])->with('items');
		}, 'property', 'client', 'category'])->get();
		
		$jobsArray = [];
		$jobs->groupBy('property_id')->each(function($job) use($db_date_range, &$jobsArray){
			$job->each(function($j) use($db_date_range, &$jobsArray)
			{
				if(!array_key_exists($j->property_id, $jobsArray))
					$jobsArray[$j->property_id] = new \stdClass();
				$dates = [];
				foreach($db_date_range as $date)
				{
					$visit = $j->visits->where('date', $date)->first();
					$dates[$date] = $visit? $visit->items->first()->pivot->total: 0;
				}
				$jobsArray[$j->property_id]->property = $j->property->address;
				$jobsArray[$j->property_id]->client = $j->client->name;
				$jobsArray[$j->property_id]->category = $j->category->type;
				$jobsArray[$j->property_id]->title = $j->job_title;
				$jobsArray[$j->property_id]->property_id = $j->property_id;
				$jobsArray[$j->property_id]->amounts = $dates;
			});
		});

		return array_values($jobsArray);
	}

}