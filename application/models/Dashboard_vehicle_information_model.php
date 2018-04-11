<?php

require_once 'application/models/Dashboard_table_base_model.php';

class Dashboard_vehicle_information_model extends Dashboard_table_base_model
{
    
    public function get()
    {
        $query = "
            SELECT v.license_plate, v.id, vr.due_date, vr.expiry_date, vr.status, vs.next_service_date, vs.next_service_odo, v.insurance_expiry_date, meter.odometer_finish
                FROM vehicle AS v
            LEFT JOIN
            (
                SELECT MAX(r.id), r.vehicle_id, r.due_date, r.expiry_date, r.status
                    FROM vehicle_rego AS r
                GROUP BY r.vehicle_id
            ) AS vr 
            ON vr.vehicle_id = v.id

            LEFT JOIN
            (
                SELECT MAX(s.id), s.vehicle_id, s.next_service_date, s.next_service_odo
                    FROM vehicle_services AS s
                GROUP BY s.vehicle_id
            ) AS vs 
            ON vs.vehicle_id = v.id

            LEFT JOIN
            (
                SELECT MAX(odo.id), odo.vehicle_id, odo.odometer_finish
                    FROM vehicle_odometer AS odo
                GROUP BY odo.vehicle_id
            ) AS meter
            ON meter.vehicle_id = v.id";

        return $this->get_result($query);
    }

    public function get_due_date_highlighted_class()
    {   
        if ($this->status == STATUS_PAID) {
            return 'bg-success';
        }
        return $this->get_class_based_on_date($this->due_date);
    }

    public function get_expiry_date_highlighted_class()
    {
        return $this->get_class_based_on_date($this->expiry_date);
    }

    public function get_insurance_expiry_date_hightlighted_class()
    {
        return $this->get_class_based_on_date($this->insurance_expiry_date);
    }

    /*
    * @params null
    * return String
    * description: check next odo Kilometers and return highlighted class depands on remaining Kilometers.
    */
    public function get_next_odo_highlighted_class()
    {
        switch(true)
        {
            case $this->next_service_odo < 5000:
                return 'bg-warning';

            case $this->next_service_odo < 1000:
                return 'bg-info';

            case $this->next_service_odo <= $this->odometer_finish:
                return 'bg-danger';

            default:
                return '';
        }
    }

    /*
    * @params null
    * return String
    */
    public function get_next_service_date_highlighted_class()
    {
        // check if there is any class available for next odo meter
        // and return empty string early if exist 
        // otherwise check date for next server
        if( $this->get_next_odo_highlighted_class() )
        {
            return '';
        }

        $this->get_class_based_on_date($this->next_service_date);
    }

    /*
    * @params null
    * return String
    */
    public function get_service_odo()
    {
        return $this->next_service_odo? $this->next_service_odo .'km':'';
    }

    /*
    * @params null
    * return String
    */
    public function get_odometer_finish()
    {
        return $this->odometer_finish? $this->odometer_finish .'km': '';
    }

}

?>