<?php


class Job_visits_model extends MY_Model
{
    const DB_TABLE = 'job_visits';
    const DB_TABLE_PK = 'id';

    public $id;
    public $job_id;
    public $completed = 0;
    public $date;
    public $notes;
    public $time_in;
    public $time_out;
    public $user_id;
    public $logged_at;

    public function getVisitsWithAssignee($job_id)
    {
        /* return $this->db->query("SELECT v.*, CONCAT(u.first_name, ' ', u.last_name) AS assignee FROM job_visits as v LEFT JOIN users as u ON u.id = v.user_id WHERE v.job_id = ?", [$job_id])
            ->result(); */
        return $this->db->query("SELECT jv.*, GROUP_CONCAT( concat(u.first_name, ' ', u.last_name) ) AS assignee, (SELECT SUM(total) FROM job_visit_item WHERE jv.id = visit_id) AS amount
                                FROM job_visits AS jv
                                JOIN job_visit_crew AS jvc ON jv.id = jvc.visit_id
                                JOIN users AS u ON u.id = jvc.user_id
                                WHERE jv.job_id = ?
                                GROUP BY jv.id", [$job_id])
            ->result();

    }

}

?>