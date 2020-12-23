<?php

/**
 * USER MODAL
 */
class Contacts_model extends MY_Model
{
    const DB_TABLE = 'contacts';
    const DB_TABLE_PK = 'id';

    public $id;
    public $contact_name;
    public $surname;
    public $role;
    public $phone;
    public $email;
    public $is_primary = 0;
    public $client_id;
    public $active = 1;

    function get_dropdown_lists($client_id=0, $first_empty=1, $active=1)
    {
        if ($client_id) {
            $filter = array('active'=>$active, 'client_id'=>$client_id );
        }else{
            $filter = array('active'=>$active);
        }
        
        $ret = array_map(

                function($o){ 
                    return $o->contact_name . ' ' . $o->surname; 
                }, 

                $this->getWhere($filter)
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

}

?>