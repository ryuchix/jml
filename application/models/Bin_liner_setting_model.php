<?php

/**
 * SERVICE MODAL
 */
class Bin_liner_setting_model extends MY_Model
{
    const DB_TABLE = 'bin_liner_setting';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $price;
    public $active;

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