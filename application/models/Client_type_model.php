<?php

/**
 * CLIENT TYPES MODAL
 */
class Client_type_model extends MY_Model
{
    const DB_TABLE = 'client_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;

    public function dropdown_list($first_empty = 'All', $active = 1)
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
			$this->getWhere(array('active'=>$active))
		); // array_map
     
        return $first_empty? array($first_empty=>$first_empty) + $ret : $ret;
    }
    
}

?>