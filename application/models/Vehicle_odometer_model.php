<?php

class Vehicle_odometer_model extends MY_Model
{
    const DB_TABLE = 'vehicle_odometer';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $vehicle_id;
    public $start_time;
    public $finish_time;
    public $odometer_start;
    public $odometer_finish;
    public $purpose_of_trip;
    public $driver;

    function get_list_by_vehicle_id($vehicle_id)
    {
        $sql = "
            SELECT vo.*, CONCAT(u.first_name, ' ', u.last_name) AS driver
            FROM vehicle_odometer AS vo
            JOIN users AS u ON u.id = vo.driver
            WHERE vo.vehicle_id = $vehicle_id
        ";

        return $this->db->query($sql)->result();
    }

}


?>

