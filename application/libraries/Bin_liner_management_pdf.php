<?php 
require_once 'FPDF.php';

/**
* Bin_liner_management_pdf PDF View
*/

class Bin_liner_management_pdf extends FPDF
{
	protected $record;

	protected $CI;

	protected $property;
	
	protected $set_text_color = array(100, 100, 100);

	protected $total_qty = 0;

	protected $grand_total = 0;

	function __construct($model=false, $orientation='L', $unit='mm', $size='A4')
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
		
		$this->Cell(0, 7, "Bin Liners Management", 0, 1, "C");
		
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 235, 5, 50 );
		
		$this->Ln(10);
	}

	/********************************* Helpers ********************************/

	function set_text_color($color=array(0, 0, 0))
	{
		$this->SetTextColor( $color );
	}

	function display_header()
	{

		$this->SetFont( 'Arial', 'B', 11 );
		
		$this->Cell(0, 10, 'Date: from ' . $this->CI->input->get('date_from') . ' to ' . $this->CI->input->get('date_to'));
		
		$this->Ln();
		
		$this->CI->load->model('Property_model');
		$this->CI->load->model('Bin_liner_setting_model');

		$address = '';

		if ($property_id = $this->CI->input->get('property')) 
		{
			$property = new Property_model();
			$property->load($property_id);

			$this->property = $property;

			$address = $property->address . ', ' . $property->address_suburb . ', ' . $property->address_state;
		}

		if ( $address ) 
		{
			$this->Cell(0, 10, 'Property: '. $address);
			
			$this->Ln();
		}

		if ($this->CI->input->get('size')) 
		{
			$size = new Bin_liner_setting_model();
			$size->load($this->CI->input->get('size'));
			$this->Cell(0, 10, 'Size: '. $size->name);
		}

		
	}

	function display_table()
	{
		$date_from = DateTime::createFromFormat('d/m/Y',$this->CI->input->get('date_from'));
		$date_to = DateTime::createFromFormat('d/m/Y',$this->CI->input->get('date_to'));
		
		$this->CI->db->select('bl.date, c.name as client, CONCAT(p.address, " ", p.address_suburb, "", p.address_state) AS property, CONCAT(staff.first_name, " ", staff.last_name) AS staff, bl.notes, bls.name AS size, bld.price, bld.qty, bld.total')
			->from('bin_liner_detail AS bld')
			->join('bin_liner AS bl', 'bld.liner_id = bl.id')
			->join('users AS staff', 'staff.id = bl.staff')
			->join('property AS p', 'p.id = bl.property_id')
			->join('client AS c', 'c.id = p.client_id')
			->join('bin_liner_setting AS bls', 'bls.id = bld.setting_id');

		if ($date_from && $date_to) 
		{
			$this->CI->db->where('bl.date >=', $date_from->format('Y-m-d'));
			$this->CI->db->where('bl.date <=', $date_to->format('Y-m-d'));
		}

		if ($size = $this->CI->input->get('size')) 
		{
			$this->CI->db->where('bls.id', $size);
		}

		if ($this->property) 
		{
			$this->CI->db->where('p.id', $this->property->id);
		}

		$results = $this->CI->db->get()->result();

		if (empty($results)) {
			echo "<h1>Oppx... no record found!</h1>";
			die();
		}

		$this->Ln(5);

		$this->SetFillColor(240, 240, 240);

		$header = array(
			"Date" 				=> 18,
			"Client Name" 		=> 52,
			"Property Name" 	=> 50,
			"Staff Name" 		=> 25,
			"Notes" 			=> 80,
			"Size" 				=> 12,
			"Price" 			=> 12,
			"Qty" 				=> 12,
			"Total" 			=> 12,
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
			$this->total_qty += $row->qty;
			$this->grand_total += $row->total;

			$widths = array_keys($header);
			$this->Cell($header["Date"], 7, local_date($row->date), 1, 0);
			$this->Cell($header["Client Name"], 7, str_limit($row->client, 31), 1, 0);
			$this->Cell($header["Property Name"], 7, str_limit($row->property, 33), 1);
			$this->Cell($header["Staff Name"], 7, str_limit($row->staff, 50), 1);
			$this->Cell($header["Notes"], 7, str_limit($row->notes), 1);
			$this->Cell($header["Size"], 7, $row->size, 1, 0, "C");
			$this->Cell($header["Price"], 7, '$'.number_format($row->price, 2), 1, 0, "C");
			$this->Cell($header["Qty"], 7, number_format($row->qty, 2), 1, 0, "C");
			$this->Cell($header["Total"], 7, '$'.number_format($row->total, 2), 1, 0, "R");
			$this->Ln();
		}

		$this->SetFont( 'Arial', 'B', 9 );
		$this->Cell($header["Date"], 7, 'Total', 1, 0, "C");
		$this->Cell($header["Client Name"], 7, '', 1, 0);
		$this->Cell($header["Property Name"], 7, '', 1);
		$this->Cell($header["Staff Name"], 7, '', 1);
		$this->Cell($header["Notes"], 7, '', 1);
		$this->Cell($header["Size"], 7, '', 1, 0, "C");
		$this->Cell($header["Price"], 7, '', 1, 0, "C");
		$this->Cell($header["Qty"], 7, number_format($this->total_qty, 2), 1, 0, "C");
		$this->Cell($header["Total"], 7, '$'.number_format($this->grand_total, 2), 1, 0, "R");

		$this->Ln(10);

	}

	function display_output()
	{
		$this->display_header();

		$this->display_table();

		$this->Output();
	}
}


 ?>