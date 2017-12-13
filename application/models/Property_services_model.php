<?php

/**
 * CLIENT TYPES MODAL
 */
class Property_services_model extends MY_Model
{
    const DB_TABLE = 'property_services';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $service_id;

    function get_dropdown_lists_by_property_id($property_id)
    {
        return array_map(

            function($o){ 
                return $o->service_id;
            }, 

            $this->getWhere(array('property_id'=>$property_id))
        );

    }
    
}

?>