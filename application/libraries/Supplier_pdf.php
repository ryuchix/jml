<?php 
require_once 'FPDF.php';

/**
* Bin_liner_management_pdf PDF View
*/

class Supplier_pdf extends FPDF
{
	protected $CI;

	protected $property;
	
	protected $set_text_color = array(100, 100, 100);

	function __construct($model=false, $orientation='L', $unit='mm', $size='A4')
	{
		parent::__construct($orientation, $unit, $size);
		// $this->record = $model;
		$this->CI = get_instance();
		$this->AddPage();
	
		$this->SetFont( 'Arial', '', 14 );		
		// Report Name
	}

	function Header()
	{
		$this->SetFont( 'Arial', 'BU', 12 );
		
		$this->Cell(0, 7, "Suppliers", 0, 1, "C");
		
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 235, 5, 50 );
		
		$this->Ln(10);
	}

	/********************************* Helpers ********************************/

	function set_text_color($r=0, $g=0, $b=0)
	{
		$this->SetTextColor( $r, $g, $b );
	}

	function display_header()
	{
		$this->SetFont( 'Arial', 'B', 11 );
		
	}

	function display_table()
	{
		$this->CI->load->model('Supplier_model');

		$results = $this->CI->Supplier_model->get();

		if (empty($results)) {
			echo "<h1>Oppx... no record found!</h1>";
			die();
		}

		$this->Ln(5);

		$this->SetFillColor(240, 240, 240);

		$header = array(
			"Name" 		=> 45,
			"Phone" 	=> 20,
			"Email" 	=> 55,
			"Website" 	=> 70,
			"Address" 	=> 75,
			"Active" 	=> 12,
		);
		
		$this->SetFont( 'Arial', '', 9);
		
		$this->Ln(5);
		
		foreach ($header as $title => $w)
		{
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $title, 1, 0, "C", 1);
		}

		$this->Ln();
		// echo strlen("Bin Liners changed by GangaBin Liners changed by G");
		// die();
		foreach ($results as $row) 
		{
			$widths = array_keys($header);
			$this->Cell($header["Name"], 7, $row->name, 1, 0);
			$this->Cell($header["Phone"], 7, str_limit($row->phone, 31), 1, 0);
			$this->Cell($header["Email"], 7, str_limit($row->email, 33), 1);
			$this->set_text_color(18, 125, 179);
			$this->Cell($header["Website"], 7, str_limit($row->website, 50), 1, 0, '', false, $row->website);
			$this->set_text_color(0, 0, 0);
			$this->Cell($header["Address"], 7, str_limit($row->address . ' ' . $row->address_suburb . ' ' . $row->address_state . ', ' . $row->address_post_code, 60), 1);
			$this->SetFont('zapfdingbats', '', 12);
			$this->Cell($header["Active"], 7, $row->active? chr(51): chr(53), 1, 0, "C");
			$this->SetFont('Arial', '', 9);
			$this->Ln();
		}
	}

	function display_output()
	{
		$this->display_header();

		$this->display_table();

		$this->Output();
	}
}


 ?>