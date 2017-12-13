<?php

/**
 * USER MODAL
 */
class Consumable_request_item_model extends MY_Model
{
    const DB_TABLE = 'consumable_request_item';
    const DB_TABLE_PK = 'id';

    public $id;
    public $consumable_id;
    public $request_id;
    public $qty;
    public $unit;

    function get_consumable_items_by_property_id($property_id)
    {
    	$sql = "SELECT c.id, 
    					client.name AS client, 
    					c.name,
    					c.ref_code AS code,
    					s.name AS supplier,
    					CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address
    			FROM property_consumables AS pc 
					JOIN consumable AS c ON c.id = pc.consumable_id
					JOIN property AS p ON p.id = pc.property_id 
					JOIN client ON client.id = p.client_id
					JOIN supplier AS s ON s.id = c.supplier_id
				WHERE p.id = $property_id";

		return $this->db->query($sql)->result();
    }

}

?>