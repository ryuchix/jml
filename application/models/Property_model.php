<?php

/**
 * USER MODAL
 */
class Property_model extends MY_Model
{
    const DB_TABLE = 'property';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $council_id = 0;
    public $contact_id;
    public $strata_plan = '';
    public $notes = '';
    public $address = '';
    public $address_state;
    public $address_long_state;
    public $address_suburb;
    public $address_post_code;
    public $address_location;
    public $active = 1;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->address . ', ' . $o->address_suburb . ', ' . $o->address_post_code; 
                },

                $this->getWhere(array('active'=>1))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_dropdown_lists_of_service($service, $first_empty=1, $active=1)
    {
        $properties = $this->db->query("SELECT id, address, address_suburb, address_post_code FROM `property` WHERE id IN ( SELECT property_id FROM property_services WHERE service_id = (SELECT id FROM service s WHERE s.name LIKE '%$service%') )")->result();

        $output = [];

        foreach ($properties as $prop) 
        {
            $output[$prop->id] = $prop->address . ', ' . $prop->address_suburb . ', ' . $prop->address_post_code; 
        }

        return $first_empty? array(''=>'') + $output : $output;
    }


    function get_dropdown_lists_by_client_id($client_id=false, $first_empty=1, $active=1)
    {
        if (!$client_id) { return false; }
        
        $ret = array_map(

                function($o){ 
                    return $o->address . ', ' . $o->address_suburb . ', ' . $o->address_post_code; 
                },

                $this->getWhere(array( 'active' => 1, 'client_id' => $client_id ))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }
    

}

?>