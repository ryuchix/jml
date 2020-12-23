<?php

class Property_consumable_item_model extends MY_Model
{
    const DB_TABLE = 'property_consumable_item';
    const DB_TABLE_PK = 'consumable_id';

    public $property_id;
    public $consumable_id;

    function get_consumable_ids_by_property_id($property_id)
    {
        $ret = array_map(
                function($o){ 
                    return $o->consumable_id; 
                },
                $this->getWhere( array( 'property_id' => $property_id ) )
            );
        return $ret;
    }

}

?>