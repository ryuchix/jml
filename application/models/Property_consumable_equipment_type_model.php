<?php

class Property_consumable_equipment_type_model extends MY_Model
{
    const DB_TABLE = 'property_consumable_equipment_type';
    const DB_TABLE_PK = 'equipment_type_id';

    public $property_id;
    public $equipment_type_id;

    function get_equipment_type_ids_by_property_id($property_id)
    {
        $ret = array_map(
                function($o){ 
                    return $o->equipment_type_id; 
                },
                $this->getWhere( array( 'property_id' => $property_id ) )
            );
        return $ret;
    }

}

?>