<?php 

require_once 'Csvexport.php';

/**
* FilteredClientCsvExport
*/
class FilteredClientCsvExport extends Csvexport
{
	protected $casts = [
		'is_parent' => 'boolean',
		'is_prospect' => 'boolean',
		'same_billing_address' => 'boolean',
		'active' => 'boolean',
	];

	protected $filteredData;

	protected function getDatas()
	{
		$columns = $this->getColumns();

		return $this->filteredData;
	}

	public function setData($data)
	{
		$this->filteredData = $data;
	}

}


?>