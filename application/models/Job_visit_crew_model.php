<?php



class Job_visit_crew_model extends MY_Model
{
    const DB_TABLE = 'job_visit_crew';
    const DB_TABLE_PK = 'user_id';

    public $job_id;
    public $user_id;

    function get_dropdown_lists($job_id, $first_empty=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->user_id;
                }, 

                $this->getWhere( array( 'job_id' => $job_id ) )
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_by_visit($visit_id)
    {
        $sql = "SELECT u.first_name, u.last_name FROM job_visit_crew AS jvc JOIN users AS u ON u.id = jvc.user_id WHERE visit_id = ?";
        return $this->db->query($sql,[$id])->result();
    }

}
?>