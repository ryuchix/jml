<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Quote_model',
			'Client_model',
			'Property_model',
			'Property_model',
			'Contacts_model',
			'User_model',
			'Service_model',
		]);
		$this->set_data('active_menu', 'quote');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'quote';
	}


	function index()
	{
		$this->redirectIfNotAllowed('view-quote');

		$this->set_data('sub_menu', 'view_quote');
		$this->set_data( 'pending_records', $this->Quote_model->get_lists(STATUS_PENDING) );
		$this->set_data( 'won_records', $this->Quote_model->get_lists(STATUS_WON) );
		$this->set_data( 'lost_records', $this->Quote_model->get_lists(STATUS_LOST) );
		$this->load->view('quotes/lists', $this->get_data());
		$this->context = 'quote';
	}

	function save($id=false)
	{
		$this->redirectIfNotAllowed( $id ? 'edit-quote' : 'add-quote', 'quote');

		$this->set_data('sub_menu', 'add_quote');
		$record = new Quote_model();
		if ($id) { $record->load($id); }
		$this->set_data('record', $record);
		$this->set_data('clients', $this->Client_model->get_dropdown_lists());
		$this->set_data('users', $this->User_model->get_dropdown_lists());
		$this->set_data('services', $this->Service_model->get_dropdown_lists());
		$this->set_data('properties', []);
		$this->set_data('contacts', []);

		if ($client_id = $this->input->post('data[client_id]')) {
			$this->set_data('properties', $this->Property_model->get_dropdown_lists_by_client_id($client_id));
			$this->set_data('contacts', $this->Contacts_model->get_dropdown_lists($client_id));
		}

		$old_status = $record->status;

		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			$this->validate_fields($id);
			if ( $this->form_validation->run() == TRUE ) {

				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$record->date = db_date($this->input->post('date'));
				$record->last_contact = db_date($this->input->post('last_contact'));
				$record->next_contact = db_date($this->input->post('next_contact'));
				$record->expected_signoff = $this->input->post('expected_signoff')? db_date($this->input->post('expected_signoff')):null;

				if ($id) {
					if ($this->input->post('data[status]') == STATUS_WON && !$this->date_won) {
						$record->date_won = date('Y-m-d');
					}
					if ($this->input->post('data[status]') == STATUS_LOST && !$this->date_lost) {
						$record->date_lost = date('Y-m-d');
					}
				}
				$inserted_id_or_affected_rows = $record->save();
				if ($inserted_id_or_affected_rows) {
					set_flash_message(0, "Record Submitted Successfully!");
					if (!$id) { 
						$id=$inserted_id_or_affected_rows;
						$this->add_history($id, "Quote added");
					}else{
						if ($old_status != $record->status && $record->status == STATUS_WON) {
							$this->add_history($id, "Quote $record->quote_no has been won.");
						}else if ($old_status != $record->status && $record->status == STATUS_LOST) {
							$this->add_history($id, "Quote $record->quote_no has been lost.");
						}else{
							$this->add_history($id, "Quote Upldated");
						}
					}
					redirect( site_url( 'quote/' ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( 'quote/' ) );
				}

			}
		}
		$this->load->view('quotes/form',$this->get_data());
	}

	function validate_fields($id)
	{
       	$this->form_validation->set_rules('date','Date','required');
       	$this->form_validation->set_rules('data[quote_no]','Quote no.','required');
       	$this->form_validation->set_rules('data[ref_no]','Reference no.','required');
       	$this->form_validation->set_rules('data[client_id]','Client.','required');
       	$this->form_validation->set_rules('data[property_id]','Property.','required');
       	$this->form_validation->set_rules('data[contact]','Contact.','required');
       	$this->form_validation->set_rules('data[sales_rep]','Sales Rep.','required');
       	$this->form_validation->set_rules('data[frequency]','Frequency.','required');
       	$this->form_validation->set_rules('data[amount]','amount.','required|numeric');
       	$this->form_validation->set_rules('data[chance]','Chance.','required');
       	$this->form_validation->set_rules('data[service_id]','Service.','required');
       	$this->form_validation->set_rules('data[status]','Status.','required');
       	$this->form_validation->set_rules('last_contact','Last Contact.','required');
       	$this->form_validation->set_rules('next_contact','Next Contact.','required');
       	// $this->form_validation->set_rules('expected_signoff','Expected Signoff.','required');
       	// $this->form_validation->set_rules('data[notes]','Expected Signoff.','required');
	}


	function forcast()
	{
		$this->redirectIfNotAllowed( 'view-forcast', 'quote');
		
		$this->set_data('sub_menu', 'sales_forcast');
		
		$months = $this->get_next_12_months();
		
		$this->set_data('months', $months);
		
		$this->set_data('records', $this->Quote_model->get_forcast());
		
		$this->load->view('quotes/forcast_lists',$this->get_data());
	}

	function pdf_view($querty_status)
	{
		$status = null;
		switch ($querty_status) {
			case 'pending':
				$status = $this->Quote_model->get_lists(STATUS_PENDING, false);
				break;
			case 'won':
				$status = $this->Quote_model->get_lists(STATUS_WON, false);
				break;
			case 'lost':
				$status = $this->Quote_model->get_lists(STATUS_LOST, false);
				break;
			
			default:
				$status = array(new Quote_model());
				break;
		}
		if (!$status || empty($status)) {
			$this->load->library('Fpdf');
			$pdf = new FPDF("L");
			$pdf->AddPage();
			$pdf->SetFont("Arial", "", 26);
			$pdf->Cell(0, 40, "No record found!", 0, 1, "C");
			$pdf->Output();
		}else{
			
			$this->load->library('Quote_view');
			$pdf = new Quote_view($status, "L");
			$pdf->status = ucfirst($querty_status);
			$pdf->AddPage();
			$pdf->display_output();
			$pdf->Output();
		}
	}

	function forecast_pdf_view()
	{	
		$records = $this->Quote_model->get_forcast(false);
		if (!$records || empty($records)) {
			$this->load->library('fpdf');
			$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetFont("Arial", "", 26);
			$pdf->Cell(0, 40, "No record found!", 0, 1, "C");
			$pdf->Output();
		}else{
			$this->load->library('Forecast_view');
			$pdf = new Forecast_view($this->get_next_12_months(), $records, "L");
			$pdf->AddPage();
			$pdf->display_output();
			$pdf->Output();
		}
	}

	function list_in_csv($querty_status)
	{

		$status = null;
		switch ($querty_status) {
			case 'pending':
				$status = $this->Quote_model->get_lists(STATUS_PENDING, false);
				break;
			case 'won':
				$status = $this->Quote_model->get_lists(STATUS_WON, false);
				break;
			case 'lost':
				$status = $this->Quote_model->get_lists(STATUS_LOST, false);
				break;
			
			default:
				$status = array(new Quote_model());
				break;
		}

		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="Quote Lists '.date('d/m/Y h.i.s').'.csv"');
		
		$data = array('Quote no.,Client,Service,Property,Status,Chance,Contact,Sales,Frequency,Value,Last,Next,Expected');
		$total = array();
		foreach ($status as $row) {
			$row_data = array();
			$row_data[] = str_replace(',', " ", $row->quote_no);
			$row_data[] = str_replace(',', " ", $row->client);
			$row_data[] = str_replace(',', " ", $row->service);
			$row_data[] = str_replace(',', " ", $row->address);
			$row_data[] = str_replace(',', " ", get_status($row->status));
			$row_data[] = str_replace(',', " ", $row->chance) . '%';
			$row_data[] = str_replace(',', " ", $row->contact);
			$row_data[] = str_replace(',', " ", $row->sales);
			$row_data[] = str_replace(',', " ", get_frequency($row->frequency));
			$row_data[] = '$'.str_replace(',', " ", $row->value);
			$row_data[] = str_replace(',', " ", local_date($row->last_contact));
			$row_data[] = str_replace(',', " ", local_date($row->next_contact));
			$row_data[] = str_replace(',', " ", local_date($row->expected_signoff));
			$data[] = join(',', $row_data);
		}

		$fp = fopen('php://output', 'w');
		foreach ( $data as $line ) {
		    $val = explode(',', $line);
		    fputcsv($fp, $val, ',',' ');
		}
		fclose($fp);

	}

	function forecast_list_in_csv()
	{
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="Forecast Lists '.date('d/m/Y h.i.s').'.csv"');
		
		$months = $this->get_next_12_months();
		$records = $this->Quote_model->get_forcast();

		$month_in_heading = [];
		foreach ($months as $month) { $month_in_heading[] = $month; }

		$data = array('Quote no.,Client,Service,'.join(',',$month_in_heading));
		$total = array();
		foreach ($records as $row) {
			$row_data = array();
			$row_data[] = str_replace(',', " ", $row->quote_no);
			$row_data[] = str_replace(',', " ", $row->client);
			$row_data[] = str_replace(',', " ", $row->service);
			foreach ($months as $month) {
	            if( !array_key_exists($month, $total) ){ $total[$month] = array(); }
				if ($row->month==$month){
					$row_data[] = '$'.$row->amount;
					$total[$month][] = $row->amount;
				}else{
					$row_data[] = '-';
				}
			}
			$data[] = join(',', $row_data);
		}

		$total_for_months = array();
		$grand_total = 0;
		foreach ($months as $month):
			if(isset($total[$month]) && array_sum($total[$month])){
				$t = array_sum($total[$month]);
				$total_for_months[] =  "$".$t;
				$grand_total += $t;
			}else{
				$total_for_months[] =  '-';
			}
		endforeach;

		$data[] = join(',',['Total,,,'. join(',', $total_for_months)]);
		$data[] = '';
		$data[] = 'Grand Total:,,,$'.$grand_total;

		$fp = fopen('php://output', 'w');
		foreach ( $data as $line ) {
		    $val = explode(',', $line);
		    fputcsv($fp, $val, ',',' ');
		}
		fclose($fp);

	}

    function history($id)
    {
        $this->load->library('form_validation');

        $this->set_data('quote_id', $id);

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('description','Description','required|max_length[255]');
            if ( $this->form_validation->run() ) {
                $this->add_history($id, $this->input->post('description'));
                set_flash_message(0, "Record Submitted Successfully!");
                redirect( site_url( "quote/history/$id" ) );
            }
        }

        $this->load->library('table');

        $this->table->set_heading('Description', 'Action by user', 'Date & Time');

        $template = array(
                'table_open' => '<table class="table table-hover table-bordered table-striped">'
        );

        $this->table->set_template($template);

        $quote = new Quote_model();
        
        $quote->load($id);

        $this->set_data('record', $quote);

        $histories = $this->History_model->get_history_by_context_id($id, $this->context, $query_object=true);

        $this->set_data('table', $this->table->generate($histories) );

        $this->load->view('quotes/history', $this->get_data());
    }

    function get_next_12_months()
    {
    	$months = array();
		$currentMonth = (int)date('m');

		for ($x = $currentMonth; $x < $currentMonth + 12; $x++) {
		    // $months[] = date('F', mktime(0, 0, 0, $x, 1));
		    $months[] = date('M-y', mktime(0, 0, 0, $x, 1));
		}

		return $months;
    }


	/************************************************ File Upload ************************************************/

    function upload_quote_file($id=0)
    {
        $this->upload_file('quotes', false, 'Quote_model', $id);
    }

    function upload_file($folder, $file_type=false, $model, $record_id)
    {
    	$config['upload_path'] = './uploads/'.$folder;

    	if ($file_type) {
        	$config['allowed_types'] = $file_type;
    	}else{
    		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    		$not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
    		if ( in_array($ext, $not_allowed_types) ) {
    			$config['allowed_types'] = 'gif|jpg|png|tif|doc|docx|word|pdf';
    		}else{
    			$config['allowed_types'] = $ext;
    		}
    	}

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
			$s = json_encode($error);
            echo $s;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

	        if ( isset($_POST['old_image']) && !empty($_POST['old_image'])) {
	        	$this->delete_uploaded_file($folder, $_POST['old_image']);
	        }

            if ( $record_id ) {
		        $record = new $model();
		        $record->load($record_id);
		        if ($record->file) {
		        	$this->delete_uploaded_file($folder, $record->file);
		        }
		        $record->file = $data['upload_data']['file_name'];
		        $record->save();
            }
            $s = json_encode($data['upload_data']);
            echo $s;
        }
    }

    function delete_uploaded_file($folder, $filename)
    {
    	$file = './uploads/'.$folder.'/'.$filename;
        if (file_exists($file)) {
        	unlink($file);
        	return true;
        }
        return false;
    }

    function delete_via_ajax($folder, $model)
    {
    	if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
    		$model = $model.'_model';
    		$record = new $model();
    		$record->load($_POST['rec']);
    		$record->image = '';
    		$record->save();
    	}
    	if (isset($_POST['file_name'])) {
    		echo json_encode( array('status' => $this->delete_uploaded_file($folder, $_POST['file_name']) ) );
    	}
    }


}