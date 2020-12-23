<?php

class Equipment_tags_model extends MY_Model
{
    const DB_TABLE = 'equipment_tags';
    const DB_TABLE_PK = 'id';

    public $id;
    public $equipment_id;
    public $booked_date;
    public $cost;
    public $file = '';
    public $next_service_date = null;
    public $supplier_id;

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

    function get_lists_by_equipment_id($eq_id)
    {
        $sql = "
            SELECT et.id, et.booked_date, et.next_service_date, et.cost, s.name, et.equipment_id 
                FROM equipment_tags AS et 
                    JOIN supplier AS s ON s.id = et.supplier_id
                WHERE et.equipment_id = $eq_id
        ";
        return $this->db->query($sql)->result();
    }

}

?>