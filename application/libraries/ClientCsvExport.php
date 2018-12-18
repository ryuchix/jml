<?php 

require_once 'Csvexport.php';

/**
* Complain PDF View
*/
class ClientCsvExport extends Csvexport
{
	protected $casts = [
		'is_parent' => 'boolean',
		'is_prospect' => 'boolean',
		'same_billing_address' => 'boolean',
		'active' => 'boolean',
	];

	protected function getDatas()
	{
		$columns = $this->getColumns();

		$data = $this->CI->db->query("SELECT 
					c.id, c.name, 
					ct.type as client_type, 
					cp.name AS parent_name,
					lt.type as lead_type, 
					c.phone, 
					c.email, 
					c.website, 
					c.strata_plan, 
					c.is_parent, 
					c.child_of, 
					c.is_prospect, 
					c.address_1, 
					c.address_2, 
					c.address_state, 
					c.address_long_state, 
					c.address_suburb, 
					c.address_post_code, 
					c.address_location, 
					c.same_billing_address, 
					c.attention, 
					c.co, 
					c.billing_address_1, 
					c.billing_address_2, 
					c.address_street, 
					c.billing_address_street, 
					c.billing_state, 
					c.billing_long_state, 
					c.billing_suburb, 
					c.billing_post_code, 
					c.billing_address_location, 
					c.active
                FROM client AS c
                    JOIN lead_type AS lt ON lt.id = c.lead_type
                    JOIN client_type AS ct ON ct.id = c.client_type
                    LEFT JOIN client AS cp ON c.child_of = cp.id
                WHERE c.is_prospect = 0")
			->result_array();

		return $data;
	}

}


?>