<?php

/**
 * SERVICE MODAL
 */
class Lead_type_model extends MY_Model
{
    const DB_TABLE = 'lead_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
    public $updated_by;

    public function dropdown_list($first_empty = '', $active = 1)
    {
    	switch($active)
    	{
    		case 1:
    			$this->db->where('active', 1);
    		break;
    		case 2:
    			$this->db->where('active', 0);
    		break;
    		default:
    		break;
    	}

    	$this->db->order_by('type');

    	$ret = array_map(
    		function($o){ 
                return $o->type; 
            }, 
    	$this->get());

        return $first_empty? array($first_empty=>$first_empty) + $ret : $ret;
    }

}

?>