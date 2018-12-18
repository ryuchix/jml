<?php 

/**
* Complain PDF View
*/
abstract class Csvexport
{
	protected $table;

	protected $CI;

	protected $includeColumns = [];

	protected $excludeColumns = [];

	protected $columns = [];

	protected $casts = [];

	protected $handler = null;

	function __construct($model=false)
	{
		if ($model) {
			$refl = new ReflectionClass($model);
			$this->table = $refl->getConstants()['DB_TABLE'];
			$this->CI = get_instance();
		}
	}

	public function includeColumns($columns)
	{
		if (is_array($columns)) 
		{
			foreach ($columns as $col) 
			{
				$this->includeColumns[] = $col;
			}

			return;
		}
		
		$this->includeColumns[] = $columns;
	}

	public function excludeColumns($columns)
	{
		if (is_array($columns)) 
		{
			foreach ($columns as $col) 
			{
				$this->excludeColumns[] = $col;
			}

			return;
		}
		
		$this->excludeColumns[] = $columns;
	}

	public function export($where = '')
	{
		$this->data = $this->getDatas();

		if (empty($this->data)) {
			die('No record found!');
		}

		$this->makeColumnsName();

		ob_start();

		$this->handler = fopen("php://output", 'w');

		$this->setHeaders();

		$this->setBody();

		fclose($this->handler);

		$now = gmdate("D d M Y H:i:s");
	    // header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");
		header('Content-Type: application/csv');
        
	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename=clients_{$now}.csv");
	    header("Content-Transfer-Encoding: binary");
		
		echo ob_get_clean();
	}

	protected function makeColumnsName()
	{
		$resultColumns = array_keys((array)$this->data[0]);

		$this->columns = $this->includeColumns;

		if ( empty($this->includeColumns) ) 
		{
			$this->columns = $resultColumns;
		}

		if ( !empty($this->excludeColumns) ) 
		{
			foreach ($this->excludeColumns as $col) 
			{
				$this->removeColumn($col);
				
			}
		}

	}

	protected function removeColumn($columnValue)
	{
		if (($key = array_search($columnValue, $this->columns)) !== false) 
		{
			unset($this->columns[$key]);
		}
	}

	protected function setHeaders()
	{
			$this->includeColumns = array_keys((array)$this->data[0]);

			$headers = array_map(function ($col)
			{
				return strtoupper(str_replace('_', ' ', $col));
			}, $this->columns);

			fputcsv( $this->handler, $headers );
	}

	protected function setBody()
	{
		foreach ( $this->data as $row ) 
		{
			$row = (array)$row;

			$rowData = [];

			foreach ($this->columns as $col) {

				$value = $row[$col];

				if(array_key_exists($col, $this->casts) && $this->casts[$col] == 'boolean')
					$value = $row[$col]? 'yes': 'no';

				$rowData[] = $value;
			}

			fputcsv( $this->handler, $rowData);
		}
	}

	abstract protected function getDatas();

	protected function getColumns()
	{
		$columns = '*';

		if (!empty($this->includeColumns))
		{
			$columns = join(', ', $this->columns);
		}
		
		return $columns;
	}

}


?>