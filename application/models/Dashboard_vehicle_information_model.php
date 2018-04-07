<?php

class Dashboard_vehicle_information_model extends CI_Model
{
    public function get()
    {
        $query = "
            SELECT v.license_plate, v.id, vr.due_date, vr.expiry_date, vs.next_service_date, vs.next_service_odo, v.insurance_expiry_date, meter.odometer_finish
                FROM vehicle AS v
            LEFT JOIN
            (
                SELECT MAX(r.id), r.vehicle_id, r.due_date, r.expiry_date
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

        $res = [];

        foreach ($this->db->query($query)->result() as $row) 
        {
            array_push($res, $this->populate($row));
        }

        return $res;
    }

    protected function populate($data)
    {
        $class = get_class($this);

        $info = new $class;

        foreach (get_object_vars($data) as $key => $value) 
        {
            $info->{$key} = $value;
        }

        return $info;
    }

    public function get_due_date_highlighted_class()
    {   
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

    protected function get_class_based_on_date($dateToCheck)
    {
        if ( !$dateToCheck ) { return ''; }

        $dateToCheck = new DateTime($dateToCheck);

        $today = new DateTime();

        $monthOffset = (new DateTime())->modify("+1 month");

        $weekOffset = (new DateTime())->modify("+1 week");

        switch(true)
        {
            case $dateToCheck <= $weekOffset && $dateToCheck > $today:
                return 'bg-info';

            case $dateToCheck <= $monthOffset && $dateToCheck > $today:
                return 'bg-warning';

            case $today > $dateToCheck:
                return 'bg-danger';

            default:
                return '';
        }
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