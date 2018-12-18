<?php 


/**
* 
*/
class Dashboard_table_base_model extends CI_Model
{

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

    protected function get_result($sql)
    {
        $res = [];

        foreach ($this->db->query($sql)->result() as $row) 
        {
            array_push($res, $this->populate($row));
        }

        return $res;
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
}

 ?>