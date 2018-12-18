<?php 
require_once 'FPDF.php';

/**
* Complain PDF View
*/
class Complainpdf extends FPDF
{
	protected $record;
	
	protected $set_text_color = array(100, 100, 100);

	function __construct($model=false, $orientation='P', $unit='mm', $size='A4')
	{
		parent::__construct($orientation='P', $unit='mm', $size='A4');
		// $this->record = $model;
		$this->AddPage();
	
		$this->SetFont( 'Arial', '', 14 );		
		// Report Name
	}

	function set_data($rec)
	{
		$this->record = $rec;
	}

	function Header()
	{
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 155, 5, 50 );
		
		$this->Ln(20);
		// $this->setIssueNumber($this->record);
	}

	function setIssueNumber()
	{
		$this->SetFont( 'Arial', 'B', 10 );
		
		$this->SetXY(10, 10);
		
		$this->Cell(0, 10, 'Complaint No. '.$this->record->id, 0, 1);
		
		$this->SetFont( 'Arial', 'BU', 14 );
		
		$this->Cell(0, 10, 'Issues / Complaints', 0, 1, "C");
	}

	/********************************* Helpers ********************************/

	function set_text_color($color=array(0, 0, 0))
	{
		$this->SetTextColor( $color );
	}

	function display_header()
	{
		$user = new User_model();

		$user->load($this->record->assigned_to);
		
		$assigned = $user->first_name . ' ' . $user->last_name;

		$user->load($this->record->reported_by);
		
		$reported_by = $user->first_name . ' ' . $user->last_name;

		$this->SetFillColor(240, 240, 240);

		$data = array(
			"Issue Date" 		=> local_date($this->record->complain_date),
			"Reported By" 		=> $reported_by,
			"Assigned" 			=> $assigned,
			"Status" 			=> get_status($this->record->status),
		);
		
		$this->SetFont( 'Arial', '', 10 );
		
		$this->Ln(5);
		
		$w = 47.5;
		
		foreach ($data as $key => $value) 
		{
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $key, 1, 0, "C", 1);
		}
		
		$this->Ln();
		
		foreach ($data as $key => $value) {
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $value, 1, 0, "C");
		}
		
		$this->Ln(10);
	}

	function display_history()
	{

		$this->Ln(5);
		
		$this->SetFont( 'Arial', 'BU', 12 );
		
		$this->Cell(0, 7, "Issues / Complaints Histories", 0, 1, "C");

		$h = new History_model();

        $histories = $h->get_history_by_context_id($this->record->id, 'complaints');

		$this->SetFillColor(240, 240, 240);

		$header = array(
			"Description" 		=> 101,
			"Action by user" 	=> 30,
			"Date & Time" 		=> 60,
		);
		
		$this->SetFont( 'Arial', '', 9 );
		
		$this->Ln(5);
		
		foreach ($header as $title => $w) 
		{
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $title, 1, 0, "C", 1);
		}

		$this->Ln();

		foreach ($histories as $history) 
		{
			$widths = array_keys($header);
				// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($header["Description"], 7, $history->description, 1, 0);
			
			$this->Cell($header["Action by user"], 7, $history->user, 1, 0, "C");
			
			$this->Cell($header["Date & Time"], 7, $history->time, 1, 0, "C");
			
			$this->Ln();
		}

		$this->Ln(10);

	}

	function display_output()
	{
		$this->setIssueNumber();
		
		$this->display_header();

		$this->SetFont( 'Arial', 'B', 12 );
		
		$this->Cell(0, 10, 'Title:');
		
		$this->Ln();
		
		$this->SetFont( 'Arial', '', 11 );
		
		$this->Write(4, $this->record->title);
		
		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );
		
		$this->Cell(0, 10, 'Issue / Complaints Details:');
		
		$this->Ln();
		
		$this->SetFont( 'Arial', '', 11 );
		
		$this->Write(4, $this->record->complain_details);
		
		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );
		
		$this->Cell(0, 10, 'First Responsive Corrective Action:');
		
		$this->Ln();
		
		$this->SetFont( 'Arial', '', 11 );
		
		$this->Write(4, $this->record->first_response_corrective_action);
		
		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );
		
		$this->Cell(0, 10, 'Suspected Cause:');
		
		$this->Ln();
		
		$this->SetFont( 'Arial', '', 11 );
		
		$this->Write(4, $this->record->suspected_cause);
		
		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );
		
		$this->Cell(0, 10, 'Corrective Action Response');
		
		$this->Ln();
		
		$this->SetFont( 'Arial', '', 11 );
		
		$this->Write(4, $this->record->corrective_action_response);
		
		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );

		$this->Cell(0, 10, 'Corrective Action Follow-up');

		$this->Ln();

		$this->SetFont( 'Arial', '', 11 );

		$this->Write(4, $this->record->corrective_action_followup);

		$this->Ln(8);

		$this->SetFont( 'Arial', 'B', 12 );

		$this->Cell(0, 10, 'What steps should be considered to avoid a repeat of the problem:');

		$this->Ln();

		$this->SetFont( 'Arial', '', 11 );

		$this->Write(4, $this->record->step_to_avoid_same_issue);

		$this->Ln(8);

		$this->display_history();

		$this->Output();
	}
}


 ?>