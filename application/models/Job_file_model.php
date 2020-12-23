<?php

class Job_file_model extends MY_Model
{
    const DB_TABLE = 'job_files';
    const DB_TABLE_PK = 'id';

    public $id;
    public $job_id;
    public $name;
    public $size = 1;
    public $created_by;

}

?>