<?php 
require_once 'FPDF.php';

/**
* Quote List PDF View
*/
class Forecast_view extends FPDF
{
	protected $record;
	protected $set_text_color = array(100, 100, 100);
	public $status;
	public $header;
	public $months;
	private $total;
	private $is_last_page = false;
	private $left_padding = 5;
	private $table_starting_Y_position = 5;
	private $month_column_width = 13;

	function __construct($months=[], $data=null, $orientation='P')
	{
		parent::__construct($orientation, $unit='mm', $size='A4');
		$this->header = array(
			"Quote no" 			=> 18,
			"Client" 			=> 40,
			"Property" 			=> 40,
			"Service" 			=> 24,
		);
		$this->data = $data;
		$this->months = $months;
	}

	function set_data($rec)
	{
		$this->record = $rec;
	}

	function Header()
	{		
		// Logo
		$this->Image( base_url('assets/images/logo.png'), 240, 5, 50 );
		$this->Ln(5);
		// $this->setIssueNumber($this->record);
		// $this->SetFont( 'Arial', 'B', 10 );
		// $this->SetXY(10, 10);
		// $this->Cell(0, 10, 'Complaint No. '.$this->record->id, 0, 1);
		$this->SetFont( 'Arial', 'BUI', 14 );
		$this->Cell(0, 10, 'Sales Forecast', 0, 1, "C");
		
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
		$this->SetFont( 'Arial', '', 9 );
		foreach ($this->header as $title => $w) {
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($w, 7, $title, 1, 0, "C", 1);
		}
		foreach ($this->months as $month) {
			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($this->month_column_width, 7, $month, 1, 0, "C", 1);
			
			$total = array();
            if( !array_key_exists($month, $total) ){
                $total[$month] = array();
            }
            $this->total = $total;
		}
		$this->Ln();
	}

	function display_output()
	{

		$this->table_starting_Y_position = $this->GetY();
		$h = 6;
		$defaultFontSize = 8;
		$this->SetFont( 'Arial', '', $defaultFontSize );
		// x($this->data);
		foreach ($this->data as $row) {

			// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
			$this->Cell($this->header['Quote no'], $h, $row->quote_no, "T", 0, "C", 0, 
				($row->file)? base_url('uploads/quotes/'.$row->file):'');

			// $this->AdjustFontSize($defaultFontSize, $this->header['Client'], $row->client);
			// $this->Cell($this->header['Client'], $h, $row->client, "T");
			// $this->SetFont( 'Arial', '', $defaultFontSize );

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Client'], 6, $row->client, "T", "L");
			$new_y = $this->GetY();
			$this->SetXY($current_x + $this->header['Client'], $current_y);

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Property'], 6, $row->address, "T", "L");
			if ( $this->GetY() > $new_y ) { $new_y = $this->GetY(); }
			$this->SetXY($current_x + $this->header['Property'], $current_y);

			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$this->MultiCell($this->header['Service'], 5, $row->service, "T", "L");
			if ( $this->GetY() > $new_y ) { $new_y = $this->GetY(); }
			$this->SetXY($current_x + $this->header['Service'], $current_y);			

			foreach ($this->months as $month) {
				if ($row->month==$month):
					$this->Cell($this->month_column_width, $h, '$'.$row->amount, "T", 0, "C", 0);
                    $this->total[$month][] = $row->amount;
                else:
					$this->Cell($this->month_column_width, $h, '-', "T", 0, "C", 0);
                endif;
			}
			
			$x = $this->GetX();

			$this->Ln();
			$this->SetY($new_y);
		}
		$this->is_last_page = true;
		$this->Ln(3);
		$this->Line($this->GetX(), $this->GetY(),$x,$this->GetY());
	}

	function Footers()
	{
		$y2_before_total_row = $this->GetY();
		$this->SetFont( 'Arial', '', 9 );
		$this->SetFillColor(250, 250, 250);
		if ($this->is_last_page) {
			$this->SetY($this->GetY());
		}
		
		$this->Cell(array_sum($this->header), 7, "Total", "TB", 0, "C", 1);
		foreach ($this->months as $month) {
			if(isset($this->total[$month]) && array_sum($this->total[$month]))
				$this->Cell($this->month_column_width, 7, "$".array_sum($this->total[$month]), "TB", 0, "C", 1);
			else
				$this->Cell($this->month_column_width, 7, '-', "TB", 0, "C", 1);
		}
		$this->Ln();

		// making vertical border
		$x = $this->left_padding;
		$y2 = $this->GetY();
		$this->Line( $x, $this->table_starting_Y_position, $x, $y2);
		foreach ($this->header as $name => $width) {
			$x += $width;
			if ($name == 'Service') {
				$this->Line( $x, $this->table_starting_Y_position, $x, $y2);
			}else{
				$this->Line( $x, $this->table_starting_Y_position, $x, $y2-($y2-$y2_before_total_row));
			}
		}

		foreach ($this->months as $month) {
			$x += $this->month_column_width;
			$this->Line( $x, $this->table_starting_Y_position, $x, $y2);
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