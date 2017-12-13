<?php

class Vehicle_services_model extends MY_Model
{
    const DB_TABLE = 'vehicle_services';
    const DB_TABLE_PK = 'id';

    public $id;
    public $vehicle_id;
    public $date;
    public $odometer;
    public $cost;
    public $report = null;
    public $next_service_odo;
    public $next_service_date;
    public $supplier_id;

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

