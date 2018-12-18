<?php

/**
 * SERVICE MODAL
 */
class Job_category_model extends MY_Model
{
    const DB_TABLE = 'job_categories';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
    public $updated_by;

    public function get_dropdown_lists($first_empty=1, $only_active=true)
    {
    	$this->db->order_by('type');
    	
        $ret = array_map(

                function($o){ 
                    return $o->type; 
                }, 

                $this->getWhere(array('active'=>$only_active))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

}

?>