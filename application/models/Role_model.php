<?php

/**
 * ROLE MODAL
 */
class Role_model extends MY_Model
{
    const DB_TABLE = 'roles';

    const DB_TABLE_PK = 'id';

    public $id;

    public $name;

    public $description = '';

    public $created_by;
    
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o)
                { 
                    return $o->name; 
                },

                $this->get()
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }
    

    public function attach_permissions($permissions)
    {
    	if (!is_array($permissions)) 
    	{
    		throw new Exception("Permission Must be Array");
    	}

    	$this->db->query('DELETE FROM permission_role WHERE role_id = ?', [$this->id]);

    	$data = [];

    	foreach ($permissions as $permission_id) {

    		$temp = [];

    		$temp['role_id'] = $this->id;

    		$temp['permission_id'] = $permission_id;

    		array_push($data, $temp);

    	}

    	return $this->db->insert_batch('permission_role', $data);

    }

}

?>