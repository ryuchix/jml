<?php

/**
 * USER MODAL
 */
class Council_model extends MY_Model
{
    const DB_TABLE = 'council';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $address = '';
    public $address_state;
    public $address_long_state;
    public $address_suburb;
    public $address_post_code;
    public $phone;
    public $email;
    public $website = null;
    public $address_location;
    public $contact_name;
    public $active = 1;
    public $tender = '';
    public $waste_department = '';
    public $added_by;
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                $this->getWhere( array( 'active'=>$active ) )
            );
        return $first_empty? array('0'=>'Not Applicable') + $ret : $ret;
    }
    

}

?>