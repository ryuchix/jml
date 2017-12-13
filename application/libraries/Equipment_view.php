<?php 
require_once 'FPDF.php';



class Equipment_view extends FPDF
{
	protected 	$record;
	protected 	$set_text_color = array(100, 100, 100);
	private 	$is_last_page = false;
	private 	$left_padding = 5;
	private 	$table_starting_Y_position = 5;
	private 	$month_column_width = 13;

	function __construct($data=null, $orientation='P')
	{
		parent::__construct($orientation, $unit='mm', $size='A4');
		$this->data = $data;
	}

	function set_data($rec)
	{
		$this->record = $rec;
	}

	function Header()
	{
		$this->SetMargins(20, 20);
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 110, 10, 80 );
		$this->Ln(35);
		
		$this->display_header();
	}

	/********************************* Helpers ********************************/

	function set_text_color($color=array(0, 0, 0))
	{
		$this->SetTextColor( $color );
	}

	function display_header()
	{
		$this->left_padding = $this->GetX();
		$this->SetFillColor(240, 240, 240);
		$this->Ln(5);
		$this->SetFont( 'Arial', '', 10 );
		$this->Ln();
	}

	function display_output()
	{
		$data = array(
			// "id"			=> $this->data->id,
		    "Equipment Type"=> $this->data->type,
		    "Equipment Name"=> $this->data->name,
		    "Serial No"		=> $this->data->serial_no,
		    "Description"	=> $this->data->description,
		    "Supplier"		=> $this->data->supplier,
		    "Purchased Date"=> local_date($this->data->date),
		    // "File"			=> $this->data->image,
		    "Initial Cost"	=> '$'.$this->data->initial_cost,
		    "Assigned"		=> $this->data->assign,
		);

		$border = 1; $h = 9;
		$this->SetFont( 'Arial', 'BUI', 14 );
		$this->SetFillColor(201, 218, 248);
		$this->Cell(0, $h, 'Equipment Information', 1, 1, "C", 1);
		
		$this->left_padding = $this->GetX();
		foreach ($data as $col => $value) {
			$this->SetFont( 'Arial', '', 10 );
			// if ($col == 'description') {
			// 	$this->Cell(30, 10, ucfirst($col).": ", $border, 0);
			// 	$this->MultiCell(60, 10, ' '.$value, $border);
			// }else{
				$this->Cell(30, $h, ucfirst($col).": ", $border, 0);
				$this->AdjustFontSize(10, 140, $value);
				$this->Cell(140, $h, ' '.$value, $border, 1);
			// }
		}
		$y = $this->GetY()+5;
		$filePath = base_url('uploads/equipments/'.$this->data->image);
		if (is_array(getimagesize($filePath))) {
			$this->Image( $filePath, $this->left_padding, $y, 90 );
		}
	}

	function AdjustFontSize($fontSize, $colWidth, $text)
	{
		while( $this->GetStringWidth( $text ) > $colWidth ){
		    $fontSize--;   // Decrease the variable which holds the font size
		    $this->SetFont( 'Arial', '', $fontSize );  // Set the new font size
		}
	}
	
}


 ?>