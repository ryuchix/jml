<?php

/**
 * USER MODAL
 */
class Supplier_model extends MY_Model
{
    const DB_TABLE = 'supplier';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $phone;
    public $email;
    public $website = null;
    public $address = '';
    public $address_state;
    public $address_long_state;
    public $address_suburb;
    public $address_post_code;
    public $address_location;
    public $contact_name;
    public $active = 1;
    public $added_by;
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->name;
                }, 

                $this->getWhere( array( 'active' => $active ) )
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

}

?>