<?php



class Job_visit_item_model extends MY_Model
{
    const DB_TABLE = 'job_visit_item';
    const DB_TABLE_PK = 'job_ids';

    public $job_id;
    public $service_id;
    public $description;
    public $qty;
    public $unit_cost;
    public $total;

    function get_by_job($id)
    {
        $sql = "SELECT s.name, ji.description, ji.qty, ji.unit_cost, ji.total 
        		FROM job_services AS ji 
        		JOIN service AS s ON s.id = ji.service_id WHERE job_id = ?";
        return $this->db->query($sql,[$id])->result();
    }

}
?>