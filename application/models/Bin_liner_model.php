<?php

/**
 * SERVICE MODAL
 */
class Bin_liner_model extends MY_Model
{
    const DB_TABLE = 'bin_liner';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $property_id;
    public $staff;
    public $notes = '';

    function get_list()
    {
    	// $sql = "SELECT bl.id, bl.date, 
    	// 				CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address,
    	// 				c.name, u.user_name
    	// 		FROM bin_liner AS bl
    	// 			JOIN property AS p ON p.id = bl.property_id
    	// 			JOIN users AS u ON u.id = bl.staff
    	// 			JOIN client AS c ON c.id = p.client_id";

    	$sql = "SELECT bl.id, bl.date, 
    					CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address,
    					c.name, u.user_name,
                        GROUP_CONCAT(CONCAT(s.name, ' - ', bld.qty)) AS item_with_qty
    			FROM bin_liner AS bl
    				JOIN property AS p ON p.id = bl.property_id
    				JOIN users AS u ON u.id = bl.staff
    				JOIN client AS c ON c.id = p.client_id
                    JOIN bin_liner_detail AS bld ON bld.liner_id = bl.id
                    JOIN bin_liner_setting AS s ON s.id = bld.setting_id
                GROUP BY bl.id";
    	return $this->db->query($sql)->result();
    }

}


?>

<!-- SELECT bl.id, bl.date, 
    					CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address,
    					c.name, u.user_name
    			FROM bin_liner AS bl
    				JOIN property AS p ON p.id = bl.property_id
    				JOIN users AS u ON u.id = bl.staff
    				JOIN client AS c ON c.id = p.client_id
                    JOIN (
                    	SELECT GROUP_CONCAT(CONCAT(s.name, ' - ', bld.qty)) AS item_with_qty, bld.liner_id
                        FROM bin_liner_setting AS s
                        	JOIN bin_liner_detail AS bld ON bld.setting_id = s.id
                        WHERE bld.liner_id = bl.id
                    ) AS x ON x.liner_id = bl.id -->