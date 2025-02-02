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
    public $wa_top_cc = 0;
    public $added_by;
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $this->db->order_by("type='other', type asc");
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