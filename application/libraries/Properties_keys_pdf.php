<?php 
require_once 'FPDF.php';

/**
* Properties Keys PDF View
*/

class Properties_keys_pdf extends FPDF
{
	protected $CI;

	protected $property;
	
	protected $set_text_color = array(100, 100, 100);

	function __construct($model=false, $orientation='P', $unit='mm', $size='A4')
	{
		parent::__construct($orientation, $unit, $size);
		// $this->record = $model;
		$this->CI = get_instance();
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
		$this->SetFont( 'Arial', 'BU', 12 );
		
		$this->Cell(0, 7, "Properties Keys", 0, 1, "C");
		
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 10, 5, 50 );
		
		$this->Ln();
	}

	/********************************* Helpers ********************************/

	function set_text_color($color=array(0, 0, 0))
	{
		$this->SetTextColor( $color );
	}

	function display_header()
	{
		$this->SetFont( 'Arial', 'B', 11 );
	}

	function display_table()
	{
		// $this->CI->db
		// 	->select('pk.description, kt.type AS key_type, c.name as client, CONCAT(p.address, " ", p.address_suburb, " ", p.address_state) AS property')
		// 	->from('property_keys AS pk')
		// 	->join('property AS p', 'p.id = pk.property_id')
		// 	->join('key_type AS kt', 'kt.id = pk.key_type_id')
		// 	->join('client AS c', 'c.id = p.client_id');

		
		// x($this->CI->db->last_query());

		$results = $this->getData();
		
		if (empty($results)) {
			echo "<h1>Oppx... no record found!</h1>";
			die();
		}

		$this->Ln(5);

		$this->SetFillColor(240, 240, 240);

		$header = array(
			"ID" 					=> 32,
			"Key Type" 				=> 60,
			"Description" 			=> 60,
			"Internal Reference" 	=> 35,
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
		foreach ($results as $property => $keys)
		{
			$this->Cell(array_sum($header), 7, "Property: $property", 0, 0);
			$this->Ln();

			foreach ($keys as $row) 
			{
				$this->Cell($header["ID"], 7, str_limit('Key-'.$row->id, 50), 1, 0);
				$this->Cell($header["Key Type"], 7, str_limit($row->type, 50), 1);
				$this->Cell($header["Description"], 7, str_limit($row->description), 1);
				$this->Cell($header["Internal Reference"], 7, str_limit($row->internal_reference, 50), 1);
				$this->Ln();
			}
		}
	}

	function display_output()
	{
		$this->display_header();

		$this->display_table();

		$this->Output();
	}

	protected function getData()
	{
		$this->CI->db
			->select('kt.id, kt.type, kt.description, pk.internal_reference, CONCAT(p.address, " ", p.address_suburb, " ", p.address_state) AS property')
			->from('key_type AS kt')
			->join('property_keys AS pk','pk.key_type_id = kt.id')
			->join('property AS p', 'pk.property_id = p.id')
			->order_by('property');

		$results = $this->CI->db->get()->result();

		$temp = [];

		foreach ($results as $row) 
		{
			$temp[$row->property][] = $row;
		}

		return $temp;
	}

}
