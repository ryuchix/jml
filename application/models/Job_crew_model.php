<?php



class Job_crew_model extends MY_Model
{
    const DB_TABLE = 'job_crew';
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

    function get_by_job($id)
    {
        $sql = "SELECT u.first_name, u.last_name FROM job_crew AS jc JOIN users AS u ON u.id = jc.user_id WHERE job_id = ?";
        return $this->db->query($sql,[$id])->result();
    }

}
?>