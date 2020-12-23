<?php

/**
 * SERVICE MODAL
 */
class Document_type_model extends MY_Model
{
    const DB_TABLE = 'document_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $editable = 1;
    // public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->type; 
                }, 

                $this->getWhere( array( 'active' => $active ) )
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

}

?>