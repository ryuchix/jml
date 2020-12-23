<?php

class Property_consumable_equipment_model extends MY_Model
{
    const DB_TABLE = 'property_consumable_equipment';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $consumable_id;
    public $consumable_names;
    public $equipment_type_names;
    public $equipment_type_id;

    function get_lists_by_property_id($property_id)
    {
    	$sql = "
			SELECT pce.id, pce.property_id, c.name AS consumable, et.type AS equipment
			FROM property_consumable_equipment AS pce 
				JOIN consumable AS c ON c.id = pce.consumable_id
				JOIN equipment_type AS et ON et.id = pce.equipment_type_id 
			WHERE pce.property_id = $property_id
    	";
    	return $this->db->query($sql)->result();
    }
}

?>