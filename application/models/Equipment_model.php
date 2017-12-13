<?php

/**
 * USER MODAL
 */
class Equipment_model extends MY_Model
{
    const DB_TABLE = 'equipment';
    const DB_TABLE_PK = 'id';

    public $id;
    public $equipment_type_id;
    public $name;
    public $serial_no;
    public $image;
    public $description = '';
    public $supplier_id;
    public $purchased_date;
    public $initial_cost;
    public $assigned = null;
    public $active = 1;

    function get_dropdown_lists($first_empty=1, $active=1)
    {   
        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                $this->getWhere($filter)
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_list($active = 1)
    {
        $sql = "
            SELECT e.id, et.type, e.name, e.active, CONCAT(u.first_name, ' ', u.last_name) AS assigned
                FROM equipment AS e
                JOIN equipment_type AS et ON e.equipment_type_id = et.id 
                JOIN users AS u ON u.id = e.assigned 
            WHERE e.active = $active
        ";

        return $this->db->query($sql)->result();
    }

}

?>