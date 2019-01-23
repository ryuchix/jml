<?php 
require_once 'FPDF.php';

/**
* Quote List PDF View
*/
class Quote_view extends FPDF
{
	protected $record;
	protected $set_text_color = array(100, 100, 100);
	public $status;
	public $header;
	public $quote_won = null;
	protected $is_last_page = false;
	protected $left_padding = 5;
	protected $table_starting_Y_position = 5;

	function __construct($data=null, $orientation='P')
	{
		parent::__construct($orientation, $unit='mm', $size='A3');
		$this->header = array(
			"Quote no" 			=> 19,
			"Client" 			=> 39,
			"Service" 			=> 25,
			"Property" 			=> 43,
			"Status" 			=> 11,
			"Chance" 			=> 9,
			"Contact" 			=> 31,
			"Sales" 			=> 22,
			"Frequency" 		=> 13,
			"Yearly"		 	=> 9,
			"Last"				=> 15,
			"Next"				=> 15,
			"Expected"			=> 15,
			"Quote Won"			=> 15,
		);
		$this->header = array(
			"Quote no" 			=> 19,
			"Client" 			=> 65,
			"Service" 			=> 45,
			"Property" 			=> 55,
			"Status" 			=> 15,
			"Chance" 			=> 15,
			"Contact" 			=> 30,
			"Sales" 			=> 25,
			"Frequency" 		=> 18,
			"Value"		 		=> 15,
			"Yearly"		 	=> 15,
			"Last"				=> 20,
			"Next"				=> 20,
			"Expected"			=> 20,
			"Quote Won"			=> 20,
		);
		if ($this->quote_won) {
			$this->header['Quote Won'] = 15;
		}
		$this->data = $data;
	}

	function set_data($rec)
	{
		$this->record = $rec;
	}

	function Header()
	{		
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 355, 5, 50 );
		$this->Ln(5);
		// $this->setIssueNumber($this->record);
		// $this->SetFont( 'Arial', 'B', 10 );
		// $this->SetXY(10, 10);
		// $this->Cell(0, 10, 'Complaint No. '.$this->record->id, 0, 1);
		$this->SetFont( 'Arial', 'BUI', 14 );
		$this->Cell(0, 10, $this->status.' Quotes Lists', 0, 1, "C");
		
		$this->display_header();
	}

	/********************************* Helpers ********************************/

	function display_header()
	{
		$this->SetFillColor(240, 240, 240);
		$this->SetFont( 'Arial', '', 8.5 );
		$this->SetFont( 'Arial', '', 9 );
		$this->Ln(5);
		foreach ($this->header as $title => $w) {
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $title, 1, 0, "C", 1);
		}
		$this->Ln();
	}

	function display_output()
	{
		$currentPageY = 0;
		$h = 6;
		$defaultFontSize = $this->quote_won? 8: 8.5;
		$defaultFontSize = 9;
		$this->SetFont( 'Arial', '', $defaultFontSize );
		$this->left_padding = $this->GetX();
		$this->table_starting_Y_position = $this->GetY();
		foreach ($this->data as $row) {

			if ( ($currentPageY + $h) > 178 ) {
		        $this->Line($this->GetX(), $this->GetY(),$x,$this->GetY());
				$this->AddPage();
				$currentPageY = 0;
			}
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($this->header['Quote no'], $h, $row->quote_no, "T", 0, "C", 0, 
				($row->file)? base_url('uploads/quotes/'.$row->file):'');

			// $this->AdjustFontSize($defaultFontSize, $this->header['Client'], $row->client);
			// $this->Cell($this->header['Client'], $h, $row->client, "T");
			// $this->SetFont( 'Arial', '', $defaultFontSize );

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Client'], 5.5, $row->client, "T", "L");
			$new_y = $this->GetY();
			$this->SetXY($current_x + $this->header['Client'], $current_y);

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Service'], 5.5, $row->service, "T", "L");
			if ( $this->GetY() > $new_y ) { $new_y = $this->GetY(); }
			$this->SetXY($current_x + $this->header['Service'], $current_y);

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Property'], 5.5, $row->address, "T", "L");
			if ( $this->GetY() > $new_y ) { $new_y = $this->GetY(); }
			$this->SetXY($current_x + $this->header['Property'], $current_y);	

			$this->Cell($this->header['Status'], $h, get_status($row->status), "T", 0, "C", 0);
			$this->Cell($this->header['Chance'], $h, $row->chance.'%', "T", 0, "C", 0);

			$this->AdjustFontSize($defaultFontSize, $this->header['Contact'], $row->contact);
			$this->Cell($this->header['Contact'], $h, $row->contact, "T", 0, "L", 0);
			$this->SetFont( 'Arial', '', $defaultFontSize );
			
			$this->AdjustFontSize($defaultFontSize, $this->header['Sales'], $row->sales);
			$this->Cell($this->header['Sales'], $h, $row->sales, "T", 0, "L", 0);
			$this->SetFont( 'Arial', '', $defaultFontSize );

			$this->Cell($this->header['Frequency'], $h, get_frequency($row->frequency), "T", 0, "L", 0);
			$this->Cell($this->header['Value'], $h, '$'.$row->value, "T", 0, "C", 0);
			$this->Cell($this->header['Yearly'], $h, '$'.$row->yearly, "T", 0, "C", 0);
			$this->Cell($this->header['Last'], $h, local_date($row->last_contact), "T", 0, "C", 0);
			$this->Cell($this->header['Next'], $h, local_date($row->next_contact), "T", 0, "C", 0);
			$this->Cell($this->header['Expected'], $h, local_date($row->expected_signoff), "T", 0, "C", 0);
			$this->Cell($this->header['Quote Won'], $h, local_date($row->quote_won), "T", 0, "C", 0);
			$currentPageY = $this->GetY();
			$x = $this->GetX();
			$this->Ln();
			$this->SetY($new_y);
		}
		$this->Ln();
		$this->is_last_page = true;
		$this->Line($this->GetX(), $this->GetY(),$x,$this->GetY());
	}

	function Footer()
	{
		// if ($this->is_last_page) {
			$y2 = $this->GetY();
			$this->Line($this->left_padding, $this->table_starting_Y_position,$this->left_padding, $y2);
			foreach (array_keys($this->header) as $col) {
				$x = $this->get_width_for_column($col);
				$this->Line($x, $this->table_starting_Y_position,$x, $y2);
			}
		// }
	}

	function get_width_for_column($value)
	{
		$offset = $this->left_padding;
		if (!array_key_exists($value, $this->header)) { die("Header name not exists"); }
		foreach ($this->header as $name => $width) {
			$offset += $width;
			if ($name == $value) { break; }
		}
		return $offset;
	}

	function AdjustFontSize($fontSize, $colWidth, $text)
	{
		while( $this->GetStringWidth( $text ) > $colWidth ){
		    $fontSize--;   // Decrease the variable which holds the font size
		    $this->SetFont( 'Arial', '', $fontSize );  // Set the new font size
		}
	}

}
// keytool -exportcert -alias androiddebugkey -keystore "C:\Users\Syed Arif Iqbal\.android\debug.keystore" | "C:\OpenSSL\bin\openssl.exe" sha1 -binary | "C:\OpenSSL\bin\openssl.exe" base64
// ga0RGNYHvNM5d0SLGQfpQWAPGJ8=
// ga0RGNYHvNM5d0SLGQfpQWAPGJ8=
// hjYCxzTNIXDhY2bli6z0jZQ4lpg
 ?>