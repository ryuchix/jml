<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends MY_Controller
{
	private $file_path = "./uploads/job_attachments";

	function __construct()
	{
		parent::__construct();
		$this->load->model(['Job_model',
							'Job_category_model',
							'Job_crew_model',
							'Job_visits_model',
							'Job_visit_crew_model',
							'Job_services_model',
							'Job_notes_model',
							'Job_note_attachments_model',
							'Client_model',
							'Property_model',
							'Job_visit_item_model',
							'User_model',
							'Contacts_model',
							'Service_model'
						]);
		ini_set('memory_limit', '-1');
		$this->set_data('active_menu', 'jobs');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function index($disable = false, $modified_item_id = 0)
	{
		$this->redirectIfNotAllowed('view-job');

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'view_jobs');

		$this->set_data( 'opened_records', $this->Job_model->get_lists() );
		$this->set_data( 'closed_records', $this->Job_model->get_lists(false) );
		$this->load->view('jobs/lists', $this->get_data());
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed( $id ? 'edit-job' : 'add-job', 'jobs' );

		$this->set_data('sub_menu', 'add_job');
		$record = new Job_model();
		if ($id) { $record->load($id); }
		$this->set_data('users', $this->User_model->get_dropdown_lists(0));
		$this->set_data('services', $this->Service_model->get_dropdown_lists());
		$this->set_data('clients', $this->Client_model->get_dropdown_lists());
		$this->set_data('categoies', $this->Job_category_model->get_dropdown_lists());
		$this->set_data('properties', $this->Property_model->get_dropdown_lists_by_client_id($record->client_id));
		$this->set_data('record', $record);
		$this->set_data('line_items', $this->db->get_where('job_services', ['job_id'=>$id])->result());
		// $this->set_data('attachments', $this->Job_note_attachments_model->getWhere(['job_id'=>$id]));
		$this->set_data('crew_users', $this->Job_crew_model->get_dropdown_lists($id,0));
		$this->load->library('form_validation');

		// check if form is submitted or not.
		if( isset($_POST['submit']) ){

			// validate form
			$this->validate_fields($id);
			// x($this->input->post());

			// perform action if validate returns true
			if ( $this->form_validation->run() === TRUE ) {
				
				if ( !empty($_FILES) && $_FILES['upl_files']['error'][0] != 4) 
				{ $uploaded_files = $this->multiple_upload(); }else{ $uploaded_files = []; }

				if ($this->is_uploaded($uploaded_files)) {
					
					foreach ($this->input->post('data') as $field => $value) { 
						$record->{$field} = $value; 
					}
								
					switch ($this->input->post('data[frequency]')) {
						case 'Daily':
							$record->every_no_day = $this->input->post('every_no_day');
							break;
						case 'Weekly':
							$record->every_no_day = $this->input->post('every_no_week');
							$record->week_days 	  = $this->input->post('week_days[]')? implode(',', $this->input->post('week_days[]')):'';
							break;
						case 'Monthly':
							// x( serialize($this->input->post('selected_date_of_week')) );
							$record->every_no_day = $this->input->post('every_no_month');
							$record->month_day_or_week = $this->input->post('dayorweek_of_month');
							if ($record->month_day_or_week == 'Day of Month') {
								$record->selected_day_of_month = $this->input->post('selected_date_of_month')? implode(',', $this->input->post('selected_date_of_month')):'';
							}else{
								$record->selected_day_of_month = serialize($this->input->post('selected_date_of_week'));
							}
							break;
						default:
							$record->every_no_day = '';
							break;
					}
					// $record->month_type = $this->input->post('every_no_day');
					// x( unserialize($record->selected_day_of_month));
					// die();
					
					$record->start_date = db_date($this->input->post('start_date'));

					if (!$id) {

						// dd($this->input->post());
						// if($this->input->post('end_date'))
						$record->added_by = $this->session->userdata('user_id'); 
					}
					$record->end_date = $this->input->post('end_date')? db_date($this->input->post('end_date')): db_date($this->input->post('start_date'));

					$this->db->trans_start();
					$job_id = $record->save();
					$job_id = $id? $id : $job_id;
					$this->add_crew_members( $job_id, $this->input->post('users') );
					$this->add_line_items( $job_id, $this->input->post('line_items') );
					if ( !$id || $this->input->post('regenerate_visits') == 'yes' ) {
						$end_date = $this->input->post('end_date')? $this->input->post('end_date'): $this->input->post('start_date');
						$this->Job_visits_model->deleteWhere( ['job_id' => $job_id, 'completed'=>0] );
						$this->add_visits( $job_id, $this->input->post('start_date'), $end_date );
						// dd('inserting visits');
					}
					$this->db->trans_complete();
					if ( $this->db->trans_status() === TRUE ) {
						set_flash_message(0, "Record Submitted Successfully!");
						// die('done');
						redirect( site_url( 'jobs/' ) );
					} // if transaction successfully completed
				} // If File Successfully Uploaded
				else{
					set_flash_message(2, '<p>'. join('</p><p>', $this->upload_error) .'</p>' );
				}
			} // if form validation pass
		} // if form sumitted
		// x(validation_errors());
		$this->load->view('jobs/form',$this->get_data());
	}

	function view($id, $show_note='')
	{
		$this->redirectIfNotAllowed( 'view-job' );

		$record = new Job_model();
		$record->load($id);
		$this->set_data('record', $record);
		$client = new Client_model();
		$client->load($record->client_id);

		$property = new Property_model();
		$property->load($record->property_id);

		$contact = $this->Contacts_model->getWhere(['client_id'=>$record->client_id, 'is_primary'=>1]);
		$this->set_data('client', $client->name);
		$this->set_data('contact', ($contact && !empty($contact))? array_shift($contact):[] );
		$this->set_data('show_note', $show_note);
		$this->set_data('address', $property->address . ' ' . $property->address_suburb . ' ' . $property->address_post_code);
		$this->set_data('notes', $this->Job_notes_model->get_note_with_attachment($id));
		$this->set_data('crew_users', $this->Job_crew_model->get_by_job($id));
		$this->set_data('line_items', $this->Job_services_model->get_by_job($id));
		// $this->set_data('visits', $this->Job_visits_model->getWhere(['job_id'=>$id],false,'*'));
		$this->set_data('visits', $this->Job_visits_model->getVisitsWithAssignee($id));

		$this->load->view('jobs/view.php', $this->get_data());
	}

	function save_note($job_id, $note_id=0)
	{
		$note = new Job_notes_model();
		if( $note_id ){ $note->load($note_id); }

		if ( isset($_POST['submit']) ) {

			if ( !empty($_FILES) && $_FILES['upl_files']['error'][0] != 4) 
						{ $uploaded_files = $this->multiple_upload(); }else{ $uploaded_files = []; }
			if ($this->is_uploaded($uploaded_files)) {
				$this->db->trans_start();
				$note->note 	= $this->input->post('notes');
				$note->job_id 	= $this->input->post('job_id');

				if (!$note_id) {
					$note->added_by = $this->session->userdata('user_id');
				}

				$inserted_id = $note->save();
				$note_id = $note_id? $note_id: $inserted_id;
				$this->db->trans_complete();
				$this->add_files($note_id, $uploaded_files);
				if ($this->db->trans_status()) {
					set_flash_message(0, 'Note has been Added.' );
					redirect( site_url( "jobs/view/$job_id/show_note" ) );
				}
			}else{
				set_flash_message(2, '<p>'. join('</p><p>', $this->upload_error) .'</p>' );
				redirect( site_url( "jobs/view/$job_id/show_note" ) );
			}

		}else{
			echo "string";
		}
	}

	public function close_visit()
	{
		if (isset($_POST['visit_id'])) 
		{
			$visit = new Job_visits_model();
			$visit->load($this->input->post('visit_id'));
			$visit->user_id = $this->session->userdata('user_id');
			$visit->logged_at = db_timestamp();
			$visit->completed = 1;
			$visit->save();
			set_flash_message(0, 'Visit completed!');
			redirect( site_url("jobs/view/$visit->job_id") );
		}
	}

	function close($job_id) // close job
	{
		if ($job_id) 
		{
			$this->db->trans_start();

			$this->Job_visits_model->deleteWhere( ['job_id' => $job_id, 'completed'=>0] );
			$job = new Job_model();
			$job->load($job_id);
			$job->closed = 1;
			$job->save();
			$this->db->trans_complete();

			if ( $this->db->trans_status() === TRUE ) {
				set_flash_message(0, "Job Successfully Closed!");
				redirect( site_url( 'jobs/' ) );
			} // if transaction successfully completed

		}else{
			set_flash_message(2, 'Something Wrong.' );
			redirect( site_url( "jobs/" ) );
		}
	}

	function add_files($note_id, $files)
	{
		foreach ($files as $file) {
			$record = new Job_note_attachments_model();
			$record->note_id = $note_id;
			$record->file = $file;
			$record->save();
		}
	}

	function add_crew_members($job_id, $user_ids)
	{
		// $this->Job_crew_model->deleteWhere(['job_id'=>$job_id]);
		if($job_id)
		{
			$userIds = $this->db->query("SELECT user_id FROM `job_crew` WHERE job_id = $job_id")->result();
			$userMaps = array_map(function($user){
				return $user->user_id;
			}, $userIds);

			$user_ids = array_merge(array_diff($user_ids, $userMaps), array_diff($userMaps, $user_ids));
		}
		
		foreach ($user_ids as $user_id) {
			if(in_array($user_id, $userMaps)) continue;
			$user = new Job_crew_model();
			$user->job_id = $job_id;
			$user->user_id = $user_id;
			$user->save(true); // true will ignore the primary key
		}
	}

	function add_line_items($job_id, $line_items)
	{
		$this->Job_services_model->deleteWhere(['job_id'=>$job_id]);
		foreach ($line_items as $item) {
			// x($item);
			$service = new Job_services_model();
			$service->job_id 		= $job_id;
		    $service->service_id 	= $item['service_id'];
		    $service->description 	= $item['description'];
		    $service->qty 			= $item['qty'];
		    $service->unit_cost 	= $item['unit_cost'];
		    $service->total 		= str_replace('$', '', $item['total']);
			$service->save(true); 
			// true will ignore the primary key
		}
	}

	function add_visits($job_id, $beggin_date, $end_date)
	{
		// x($this->input->post());
		$begin = new DateTime( db_date($beggin_date) );
		$end = $end_date? new DateTime( db_date($end_date) ): $begin;
		$dates = [];

		if ( JOB_TYPE_ONE_OFF == $this->input->post('data[job_type]') ) {
			// $begin = new DateTime( '2010-05-01' );
			// $end = new DateTime( '2010-05-10' );
			// if($be)
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end->modify('+1 day'));
			// dd($this->input->post('start_date'), $end_date);
			foreach ( $period as $dt ){ $dates[] = $dt->format( "Y-m-d" ); }
		}else{			
			$day = date('l');
            $engDay = date('jS');
			switch ($this->input->post('data[visit_frequency]')) {
				case 'custom':
					$dates = $this->get_visit_dates_by_custom_frequency();
					break;
				case "Weekly on $day":
					$dates = $this->get_visit_dates_weekly();
					break;
				case "Every two weeks on $day":
					$dates = $this->get_visit_dates_weekly(2);
					break;
				case "Monthly on the $engDay day of the month":
					$dates = $this->get_visit_dates_monthly();
					break;
			}
		}
		// x($dates);
		$this->insert_visits_date($job_id, $dates);
		$this->insert_visits_crew($job_id);
		$this->insert_visits_items($job_id);
	}

	protected function insert_visits_crew($job_id)
	{
		$sql = "DELETE FROM job_visit_crew WHERE visit_id IN (SELECT id from job_visits WHERE job_id = $job_id AND completed = 0)";
		if($this->db->simple_query($sql))
		{
			$data = [];
			
			$results = $this->db->query("SELECT id as visit_id FROM job_visits Where job_id = ? AND completed = 0", [$job_id])->result();
			
			foreach($this->input->post('users') as $user)
			{
				foreach ( $results as $visit_id ){
					$temp_data = [];
					$temp_data['visit_id'] 	= $visit_id->visit_id;
					$temp_data['user_id'] 	= $user;

					$data[] = $temp_data;
				}
			}
			
			$this->Job_visit_crew_model->insert_batch($data);

		}
	}

	protected function insert_visits_items($job_id){
		$sql = "DELETE FROM job_visit_item WHERE visit_id IN (SELECT id from job_services WHERE job_id = $job_id)";
		if($this->db->simple_query($sql))
		{
			$data = [];
			
			$results = $this->db->query("SELECT id as visit_id FROM job_visits Where job_id = ?", [$job_id])->result();
			
			foreach($this->input->post('line_items') as $item)
			{
				foreach ( $results as $visit_id ){
					$temp_data = [];
					$temp_data['visit_id'] 		= $visit_id->visit_id;
					$temp_data['service_id'] 	= $item['service_id'];
					$temp_data['description'] 	= $item['description'];
					$temp_data['qty'] 			= $item['qty'];
					$temp_data['unit_cost'] 	= $item['unit_cost'];
					$temp_data['total'] 		= str_replace('$', '', $item['total']);

					$data[] = $temp_data;
				}
			}
			$this->Job_visit_item_model->insert_batch($data);
		}
	}

	function get_visit_dates_by_custom_frequency()
	{
		$dates = [];
		switch ($this->input->post('data[frequency]')) {
			case 'Daily':
				$dates = $this->get_custom_daily_visit_dates();
				break;
			case 'Weekly':
				$dates = $this->get_custom_weekly_visit_dates();
				break;
			case 'Monthly':
				$dates = $this->get_custom_mothly_visit_dates();
				break;
		}
		return $dates;
	}

	function get_custom_daily_visit_dates()
	{
		$duration = $this->input->post('data[duration]');
		$duration_string = str_replace('s', '', $this->input->post('data[duration_schedule]'));
		
		$end_date = new DateTime( db_date($this->input->post('start_date')) );
		$end_date->modify("+$duration $duration_string");
		$start_date = new DateTime( db_date($this->input->post('start_date')) );
		$dates = [$start_date->format('Y-m-d')];

		$interval = $this->input->post('every_no_day');
		do {
			$dates[] = $start_date->format('Y-m-d');
			$start_date->modify("+$interval day");
		} while ($start_date <= $end_date);

		return $dates;
	}

	function get_custom_weekly_visit_dates()
	{
		$duration = $this->input->post('data[duration]'); // 10 in years or month or week or day
		$duration_string = str_replace('s', '', $this->input->post('data[duration_schedule]')); // year month week or day
		
		// Selected first day to begin with
		$start_date = new DateTime( db_date($this->input->post('start_date')) );
		// ->modify('+10 year') modify the day so that we could get the last day or the contract
		$end_date = (new DateTime( db_date($this->input->post('start_date')) ))->modify("+$duration $duration_string");

		$interval = $this->input->post('every_no_week')? $this->input->post('every_no_week'): 0;
		$days = $this->input->post('week_days'); // Saturday, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday
		
		// add first starting date statically.
		$dates[] = $start_date->format('Y-m-d');
		do {
			for ($i=1; $i <= $interval; $i++) {
				if (in_array('sunday', $days) && $interval == 1) {
					continue;
				}else{
					$start_date->modify("next sunday");
				}
				
				if (in_array('sunday', $days) && $interval == 1 && count($days) == 1 ) {
					$start_date->modify("next sunday");
				}
			}

			foreach ( $days as $day ) { // loop in every week day and modify to next {week_day}
				if($day != 'sunday'){
					$start_date->modify("next $day");
				}else{
					if($day == 'sunday' && count($days) == 1 ){
						$start_date->modify("next $day");
					}
				}
				$dates[] = $start_date->format('Y-m-d');
			}
			
		} while ($start_date <= $end_date);
		
		// dd($dates, $start_date);

		return $dates;
	}

	function get_custom_mothly_visit_dates()
	{
		$duration = $this->input->post('data[duration]');
		$duration_string = str_replace('s', '', $this->input->post('data[duration_schedule]'));
		
		$start_date = new DateTime( db_date($this->input->post('start_date')) );
		$end_date = new DateTime( db_date($this->input->post('start_date')) );
		$end_date->modify("+$duration $duration_string");

		$interval = $this->input->post('every_no_week')?$this->input->post('every_no_week'):0;
		$days = $this->input->post('selected_date_of_month');
		$dates = [];
		if ( $this->input->post('dayorweek_of_month') == 'Day of Month' ) {
			do {
				$Y = $start_date->format('Y');
				$m = $start_date->format('m');
				foreach ( $days as $day ) {
					$day = $day<10? '0'.$day:$day;
					if ( checkdate($m, (int)$day,$Y) && 'Last day of month' != $day ) {
						$dates[] = date("$Y-$m-$day");
					}else{
						$start_date->modify("last day of this month");
						if ( !in_array($start_date->format("d"), $days) ) {
							$dates[] = $start_date->format("Y-m-d");
							break;
						}
					}
				}
				if($this->input->post('every_no_month') > 1){
					for ($i = 0; $i < $this->input->post('every_no_month')?? 1; $i++) {
						$start_date->modify("first day of next month");
					}
				}else{
					$start_date->modify("first day of next month");
				}
			} while ($start_date <= $end_date);
		}else{
			do {
				$weeks = $this->input->post('selected_date_of_week');
				$week_in_eng = ['1st'=>'first', '2nd'=>'second', '3rd'=>'third', '4th'=> 'fourth'];
				foreach ( $weeks as $week_no => $week_days ) {
					
					foreach ($week_days as $day) {
						$start_date->modify($week_in_eng[$week_no]." $day of this month");
						$dates[] = $start_date->format("Y-m-d");
					}
				}
				$start_date->modify("first day of next month");
			} while ($start_date <= $end_date);
		}

		return $dates;
	}

	function get_visit_dates_weekly($week=1)
	{
		$duration = $this->input->post('data[duration]');
		$duration_string = str_replace('s', '', $this->input->post('data[duration_schedule]'));
		
		$start_date = new DateTime( db_date($this->input->post('start_date')) );		
		$end_date = new DateTime( db_date($this->input->post('start_date')) );
		$end_date->modify("+$duration $duration_string");
		
		do {
			$dates[] = $start_date->format('Y-m-d');
			$start_date->modify("next ".date('l'));
			if ($week===2) {
				$start_date->modify("next ".date('l'));
			}
		} while ($start_date <= $end_date);

		return $dates;
	}

	function get_visit_dates_monthly()
	{
		$start_date = new DateTime( db_date($this->input->post('start_date')) );
		$dates = [$start_date->format('Y-m-d')];

		$everyXmonth = isset($_POST['every_no_month'])? $_POST['every_no_month']: 1;
		// dd($everyXmonth);
		for ($i=1; $i < $this->input->post('data[duration]'); $i++) { 
			$start_date->modify("+$everyXmonth month");
			$dates[] = $start_date->format('Y-m-d');
		}
		return $dates;
	}

	function insert_visits_date($job_id, $dates)
	{
		$data = [];
		foreach ( $dates as $date ){
			// x($dt->format( "l Y-m-d H:i:s\n" ));
			$temp_data = [];
			$temp_data['job_id'] 	= $job_id;
		    $temp_data['date'] 		= $date;
		    $temp_data['notes'] 	= '';
		    $temp_data['time_in'] 	= $this->input->post('data[start_time]');
		    $temp_data['time_out']	= $this->input->post('data[end_time]');
		    $temp_data['logged_at'] = null;

			$data[] = $temp_data;
		}
		$this->Job_visits_model->insert_batch($data);
	}

	function validate_fields($id)
	{
       	$this->form_validation->set_rules('data[client_id]','Client','required|numeric');
       	$this->form_validation->set_rules('data[property_id]','Property','required|numeric');
       	$this->form_validation->set_rules('data[job_title]','Job Description','required');
       	$this->form_validation->set_rules('users[]','User','required');
       	$this->form_validation->set_rules('line_items[]','Line Items','required');
       	
       	if($this->input->post('data[job_type]') != 1)
       	{
	       	$this->form_validation->set_rules('data[start_time]', 'Start Time', 'trim|min_length[3]|max_length[5]|callback_validate_time');
	       	$st = $this->input->post('data[start_time]');
	       	$this->form_validation->set_rules('data[end_time]', 'End Time', 'trim|min_length[3]|max_length[5]|callback_validate_time|callback_end_time_validation['.$st.']');
       	}


       	foreach ($this->input->post('line_items[]') as $key => $item) {
       		$this->form_validation->set_rules("line_items[$key][service_id]",'Line Items','required|numeric');
       		$this->form_validation->set_rules("line_items[$key][qty]",'qty','required|numeric');
       		$this->form_validation->set_rules("line_items[$key][unit_cost]",'unit_cost','required|numeric');
       	}

       	if ( $this->input->post('data[job_type]') == 2 ) {
		   	$this->form_validation->set_rules('data[start_time]','Start Time','required');
		   	$this->form_validation->set_rules('data[end_time]','End Time','required');
		}

	    $this->form_validation->set_rules('end_date','End Date','callback_end_date_validation['.$this->input->post('start_date').']');
		
		if (!$id) {
	       	// $this->form_validation->set_rules('data[job_category]','Job Category','required|numeric');
	       	$this->form_validation->set_rules('data[job_type]','Job Type','required|numeric');
	       	$this->form_validation->set_rules('start_date','Start Date','required');
	       	if ( $this->input->post('data[job_type]') == 2 ) {
			   	$this->form_validation->set_rules('data[start_time]','Start Time','required');
			   	$this->form_validation->set_rules('data[end_time]','End Time','required');
	       		$this->form_validation->set_rules('data[duration_schedule]','Duration Schedule','required');
       			$this->form_validation->set_rules('data[duration]','Duration','required|numeric');
	       	}
		}
	}

	function end_date_validation($end_date, $start_date)
	{
		$sdate = DateTime::createFromFormat('d/m/Y', $start_date);
		$edate = $end_date? DateTime::createFromFormat('d/m/Y', $end_date): null;
		if ($edate && $edate < $sdate) {
			$this->form_validation->set_message('end_date_validation', '{field} must be equal to or grater than Start Date');
            // $this->form_validation->set_message('custom_document_type_check', 'The {field} must be unique. This is already in use.');
            return false;
		}else{
            return true;
        }
	}

	public function validate_time($str)
	{
		//Assume $str SHOULD be entered as HH:MM
		$part = explode(':', $str);
		$hh = $part[0];
		$mm = isset($part[1])? $part[1]:null;

		if (!is_numeric($hh) || !is_numeric($mm))
		{
		    $this->form_validation->set_message('validate_time', 'Not numeric');
		    return FALSE;
		}
		else if ((int) $hh > 24 || (int) $mm > 59)
		{
		    $this->form_validation->set_message('validate_time', 'Invalid time');
		    return FALSE;
		}
		else if (mktime((int) $hh, (int) $mm) === FALSE)
		{
		    $this->form_validation->set_message('validate_time', 'Invalid time');
		    return FALSE;
		}
		return TRUE;
	}

	function end_time_validation($end_time, $start_time)
	{
		if( strtotime($end_time) <= strtotime($start_time) )
		{
			$this->form_validation->set_message('end_time_validation', '{field} must be grater than Start Time');
            return false;
		}
		else
		{
		 	return true;
		}
	}
    
    public function multiple_upload()
	{
	    $this->load->library('upload');
	    $number_of_files_uploaded = count($_FILES['upl_files']['name']);
	    $files = array();
	    // Faking upload calls to $_FILE
	    for ($i = 0; $i < $number_of_files_uploaded; $i++) :
	      	$_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
	      	$_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
	      	$_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
	      	$_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
	      	$_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
	      	$config = array(
		        // 'file_name'     => '',
		        'allowed_types' => 'jpg|jpeg|png|gif',
		        // 'max_size'      => 3000,
		        'overwrite'     => FALSE,
		        'upload_path' => $this->file_path
	      	);
	      	$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
    		$not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
    		if ( in_array($ext, $not_allowed_types) ) {
    			$config['allowed_types'] = 'gif|jpg|png|tif|doc|docx|word|pdf';
    		}else{
    			$config['allowed_types'] = $ext;
    		}
	      	$this->upload->initialize($config);
	      	if ( ! $this->upload->do_upload() ) :
	      		$files[] = false;
	      		// x($this->upload->display_errors());
		        $error = array('error' => $this->upload->display_errors());
	      		$this->upload_error[] = $error['error'];
	    	  else :
	        	$data = $this->upload->data();
	      		$files[] = $data['file_name'];
	      	endif;
	    endfor;
	    return $files;
	}

	function is_uploaded($data)
	{
		$uploaded = true;
		foreach ($data as $file) {
			if (!$file) {
				$uploaded = false;
				break;
			}
		}
		return $uploaded;
	}

	function delete_attachment()
	{
		if (isset($_POST['file_id'])) {
			$record = new Job_note_attachments_model();
			$record->load($_POST['file_id']);

			$file = $this->file_path.'/'.$record->file;
			if (file_exists($file)) {
				unlink($file);
				$record->delete();
				echo json_encode(['status' => true]);
			}else{
				echo json_encode(['status' => false]);
			}
		}
	}

	function validateDate($date)
	{
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    return $d && $d->format('Y-m-d') === $date;
	}

	public function clean()
	{
		$this->db->simple_query("DELETE FROM job_note_attachments");
		$this->db->simple_query("DELETE FROM job_files");
		$this->db->simple_query("DELETE FROM job_notes");
		$this->db->simple_query("DELETE FROM job_services");
		$this->db->simple_query("DELETE FROM job_visits");
		$this->db->simple_query("DELETE FROM job_crew");
		$this->db->simple_query("DELETE FROM job_visit_crew");
		$this->db->simple_query("DELETE FROM job_visit_item");
		$this->db->simple_query("DELETE FROM job");
		set_flash_message(0, 'All jobs and related data are deleted!' );
		redirect('jobs');
	}

	// Edit Individual Visit

	public function visits($visitId, $type)
	{
		switch($type)
		{
			case 'edit':
				return $this->editVisit($visitId);
			break;
			case 'users':
				return $this->getVisitUsers($visitId);
			break;
			case 'items':
				return $this->getVisitItems($visitId);
			break;
		};
		return $this->sendResponse(['message' => 'Method not allowed'], 404);
	}

	// Edit Visit By Given Id
	protected function editVisit($visitId)
	{
		$visit = JobVisit::find($visitId);
		$post = $this->input->post();
		
		if($post['regenerate'] == 'true')
		{
			$this->insertVisitData($post);
			return $this->sendResponse($visit);
			exit;
		}


		$visit->date = db_date($post['date']);
		$visit->description = $post['description'];
		$visit->title = $post['title'];
		$visit->save();
		$visit->crews()->sync($post['users']);

		$items = [];
		
		$visit->items()->sync($post['lineItems']);
		return $this->sendResponse($visit);
	}

	// Get Users List For Given Visit
	protected function getVisitUsers($visitId)
	{
		$visit = JobVisit::find($visitId);
		return $this->sendResponse($visit->crews);
	}

	// Get Users List For Given Visit
	protected function getVisitItems($visitId)
	{
		$visit = JobVisit::find($visitId);
		return $this->sendResponse($visit->items);
	}

	protected function insertVisitData($post)
	{
		$visits = JobVisit::where('job_id', $post['job_id'])->where('completed', 0)->select('id', 'date')->get();

		$sql = "DELETE FROM job_visit_crew WHERE visit_id IN (SELECT id from job_visits WHERE job_id = " . $post['job_id'] . " AND completed = 0)";
		if($this->db->simple_query($sql))
		{
			$data = [];
			
			$results = $this->db->query("SELECT id as visit_id FROM job_visits Where job_id = ? AND completed = 0", [$post['job_id']])->result();
			
			foreach($post['users'] as $user)
			{
				foreach ( $results as $visit_id ){
					$temp_data = [];
					$temp_data['visit_id'] 	= $visit_id->visit_id;
					$temp_data['user_id'] 	= $user;

					$data[] = $temp_data;
				}
			}
			
			$this->Job_visit_crew_model->insert_batch($data);
		}

		$sql = "DELETE FROM job_visit_item WHERE visit_id IN (SELECT id from job_visits WHERE completed = 0 AND job_id = " . $post['job_id'] . ")";
		if($this->db->simple_query($sql))
		{
			
			$data = [];
			
			$results = $this->db->query("SELECT id as visit_id FROM job_visits Where completed = 0 AND job_id = ?", [$post['job_id']])->result();
			foreach($post['lineItems'] as $item)
			{
				foreach ( $results as $visit_id ){
					$temp_data = [];
					$temp_data['visit_id'] 		= $visit_id->visit_id;
					$temp_data['service_id'] 	= $item['service_id'];
					$temp_data['description'] 	= $item['description'];
					$temp_data['qty'] 			= $item['qty'];
					$temp_data['unit_cost'] 	= $item['unit_cost'];
					$temp_data['total'] 		= str_replace('$', '', $item['total']);

					$data[] = $temp_data;
				}
			}
			$this->Job_visit_item_model->insert_batch($data);
		}

	}

}