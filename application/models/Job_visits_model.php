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

}

?>