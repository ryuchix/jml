<?php

class Vehicle_fuel_model extends MY_Model
{
    const DB_TABLE = 'vehicle_fuel';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $vehicle_id;
    public $odometer;
    public $cost;
    public $volume;

    function get_list_by_vehicle_id($vehicle_id)
    {
        $sql = "
            SELECT vs.*, s.name AS supplier
            FROM vehicle_services AS vs
            JOIN supplier AS s ON s.id = vs.supplier_id
            WHERE vs.vehicle_id = $vehicle_id
        ";

        return $this->db->query($sql)->result();
    }

}


?>

