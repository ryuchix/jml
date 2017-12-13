<?php

/**
 * CLIENT TYPES MODAL
 */
class Gallery_type_model extends MY_Model
{
    const DB_TABLE = 'gallery_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->type; 
                }, 

                $this->getWhere(array('active'=>$active))
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }
    
}

?>