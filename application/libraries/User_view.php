<?php 
require_once 'FPDF.php';

/**
* Quote List PDF View
*/
class User_view extends FPDF
{
	protected $user;
	protected $set_text_color = array(100, 100, 100);
	private $is_last_page = false;
	private $first_column_width = 70;
	private $left_padding;
	private $second_column_offsetX;
	private $third_column_offsetX;
	private $shouldDrawLine = 0;

	function __construct($data=null, $orientation='P')
	{
		parent::__construct($orientation, $unit='mm', $size='A4');
		$this->user = $data;
	}

	function Header()
	{		
		$this->left_padding = $this->GetX();
		$this->first_column_width 		= 70 - $this->left_padding;
		$this->second_column_width 		= 80 - $this->left_padding;
		$this->third_column_width 		= 80 - $this->left_padding;
		$this->forth_column_width 		= 80 - $this->left_padding;

		$this->second_column_offsetX 	= $this->first_column_width+$this->left_padding;
		$this->third_column_offsetX 	= $this->second_column_offsetX+$this->second_column_width+6;
		$this->forth_column_offsetX 	= $this->third_column_offsetX+$this->third_column_width+6;

		// Logo
		$this->Image( base_url('assets/images/logo.png'), 240, 5, 50 );
		$this->Ln(5);
		$this->SetFont( 'Arial', 'BUI', 14 );
		$this->Cell(0, 10, 'User Details', 0, 1, "C");
		$this->SetFont( 'Arial', '', 10 );
	}

	/********************************* Helpers ********************************/

	function display_first_column()
	{
		$width = $this->first_column_width-6;
		// $this->Ln();
		$img = $this->user->image;
		if ( $this->user->image ) {
			$this->Image( base_url("uploads/profile_images/$img"), 10, 30, $width, $width );
		}else{
			$this->Image( base_url("uploads/profile_images/user-placeholder.jpg"), 10, 30, $width, $width);
		}
		$this->SetY($width+35);
		$this->Cell($width, 10, sprintf("Full Name: %s %s", $this->user->first_name, $this->user->last_name), 0, 1);
		$this->Cell($width, 10, "Username: ".$this->user->user_name, 0, 1);
		$this->MultiCell($width, 5, sprintf("Address: %s %s %s",$this->user->address,$this->user->address_suburb,$this->user->address_state), 0, "L");

		if ($this->shouldDrawLine) 
		{
			$this->Line($this->first_column_width+$this->left_padding-3, 30, $this->first_column_width+$this->left_padding-3, 200);
		}
		$this->SetXY($this->second_column_offsetX, 30);
	}

	function display_second_column()
	{
		$info = array(
			"First name" => $this->user->first_name,
			"Last name" => $this->user->last_name,
			"Username" => $this->user->user_name,
			"Email" => $this->user->email,
			"Role" => get_user_role($this->user->user_role),
			// "Role" => $this->user->user_role,
			"Date of Birth" => $this->user->dob? local_date($this->user->dob):'',
			"Mobile" => $this->user->phone
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->Cell($this->second_column_width,10, "Information", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->second_column_offsetX);
			$this->Cell(($this->second_column_width/2)-10,10, "$key:", 1, 0, "L");
			$this->Cell(($this->second_column_width/2)+10,10, $value, 1, 1, "L");
		}

		$this->Ln(10);
		$info = array(
			"Address" => $this->user->address,
			"State" => $this->user->address_state,
			"State" => $this->user->address_long_state,
			"Suburb" => $this->user->address_suburb,
			"Postcode" => $this->user->address_post_code,
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetX($this->second_column_offsetX);
		$this->Cell($this->second_column_width,10, "Address Details", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->second_column_offsetX);
			$this->Cell(($this->second_column_width/2)-10,10, "$key:", 1, 0, "L");
			$this->Cell(($this->second_column_width/2)+10,10, $value, 1, 1, "L");
		}

		if ($this->shouldDrawLine) {
			$this->Line(
				$this->first_column_width+
				$this->second_column_width+
				$this->left_padding+3, 30,

				$this->first_column_width+
				$this->second_column_width+
				$this->left_padding+3, 200);
		}

		$this->SetXY($this->first_column_width+$this->left_padding, 30);
	}

	function display_third_column()
	{
		$info = array(
			"Name" 	=> $this->user->kin_name,
			"Relationship" 	=> $this->user->kin_relationship,
			"Phone"			=> $this->user->kin_phone,
			"Address" 		=> $this->user->kin_address,
			"State" 		=> $this->user->kin_address_state,
			"Suburb" 		=> $this->user->kin_address_suburb,
			"Postcode" 		=> $this->user->kin_address_post_code
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetX($this->third_column_offsetX);
		$this->Cell($this->third_column_width,10, "Next of Kin Information", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->third_column_offsetX);
			$this->Cell(($this->third_column_width/2)-10,10, "$key:", 1, 0);
			$this->Cell(($this->third_column_width/2)+10,10, $value, 1, 1);
		}

		$this->Ln(10);
		$info = array(
			"Color" 	=> $this->user->system_color,
			"Base Rate" => "$".$this->user->base_rate,
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetX($this->third_column_offsetX);
		$this->Cell($this->third_column_width,10, "Other Details", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->third_column_offsetX);
			$this->Cell(($this->third_column_width/2)-10,10, "$key:", 1, 0, "C");
			if ($key == "Color") {
				list($r, $g, $b) = sscanf($value, "#%02x%02x%02x");
				$this->SetFillColor($r, $g, $b);
				$this->Cell(($this->third_column_width/2)+10,10, $value, 1, 1, "L", 1);
			}else{
				$this->Cell(($this->third_column_width/2)+10,10, $value, 1, 1, "L");
			}
		}
		if ($this->shouldDrawLine) 
		{
			$this->Line(
					$this->first_column_width+
					$this->second_column_width+
					$this->third_column_width+
					$this->left_padding+9, 30,

					$this->first_column_width+
					$this->second_column_width+
					$this->third_column_width+
					$this->left_padding+9, 200);
		}
	}

	function display_forth_column()
	{
		$defaultFontSize = 10;
		$info = array(
			"Australian Citizen" 	=> $this->user->australian_citizen,
			"Permanent Resident" 	=> $this->user->permanent_resident,
			"Working Visa" 			=> $this->user->working_visa,
			"Expiry Date" 			=> $this->user->expiry_date?local_date($this->user->expiry_date):'',
			"Hour/Week" 			=> $this->user->hour_per_week
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetXY($this->forth_column_offsetX, 30);
		$this->Cell($this->second_column_width,10, "Residency Details", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->forth_column_offsetX);
			$this->Cell(($this->second_column_width/2),10, "$key:", 1, 0, "L");
			$this->Cell(($this->second_column_width/2),10, $value, 1, 1, "L");
		}

		$this->Ln(7);
		$info = array(
			"Bank Name" => $this->user->bank_name,
			"BSB No." 	=> $this->user->bsb_no,
			"Account No." => $this->user->account_number
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetX($this->forth_column_offsetX);
		$this->Cell($this->second_column_width,10, "Bank Details", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->forth_column_offsetX);
			$this->Cell(($this->second_column_width/2)-10,10, "$key:", 1, 0, "L");

			$this->AdjustFontSize($defaultFontSize, ($this->second_column_width/2)+10, $value);
			$this->Cell(($this->second_column_width/2)+10,10, $value, 1, 1, "L");
			$this->SetFont( 'Arial', '', $defaultFontSize );
		}

		$this->Ln(7);
		$info = array(
			"ABN No." => $this->user->abn_no,
			"ACN No." 	=> $this->user->acn_no,
			"TFN No." => $this->user->tfn_no
		);
		$this->SetFillColor(245, 245, 245);
		$this->SetFont( 'Arial', 'BUI', 12 );
		$this->SetX($this->forth_column_offsetX);
		$this->Cell($this->second_column_width,10, "Taxation Details", 1, 1, "C", 1);
		$this->SetFont( 'Arial', '', 10 );
		foreach ($info as $key => $value) {
			$this->SetX($this->forth_column_offsetX);
			$this->Cell(($this->second_column_width/2)-10,10, "$key:", 1, 0, "L");
			$this->Cell(($this->second_column_width/2)+10,10, $value, 1, 1, "L");
		}
	}

	function display_output()
	{
		$this->display_first_column();
		$this->display_second_column();
		$this->display_third_column();
		$this->display_forth_column();
		$this->Output();
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