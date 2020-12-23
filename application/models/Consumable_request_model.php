<?php

/**
 * USER MODAL
 */
class Consumable_request_model extends MY_Model
{
    const DB_TABLE = 'consumable_request';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $request_by;
    public $date;
    public $status;
    public $po_no = null;
    public $approved_by = null;
    public $approved_at = null;
    public $added_by = 8;

    function get_list($status, $current_user=0)
    {
        $added_by = '';
        
        if ($current_user) { $added_by = "AND cr.added_by = $current_user"; }

    	$sql = "SELECT cr.id, CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address,
    				c.name,
    				cr.date,
                    CONCAT(approved_by.first_name, ' ', approved_by.last_name) AS approved_by,
                    DATE_FORMAT(cr.approved_at, '%d/%m/%Y %h:%i:%s %p') AS approved_at,
    				cr.status,
                    CONCAT(u.first_name,' ',u.last_name) AS request_by
    			FROM consumable_request AS cr 
    				JOIN property AS p ON p.id = cr.property_id
                    JOIN client AS c ON c.id = p.client_id
                    JOIN users AS u ON u.id = cr.request_by
    				LEFT JOIN users AS approved_by ON approved_by.id = cr.approved_by
                WHERE cr.status = $status $added_by";

		return $this->db->query($sql)->result();
    }

}

?>