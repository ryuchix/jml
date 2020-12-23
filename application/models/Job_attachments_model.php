<?php

class Job_attachments_model extends MY_Model
{
    const DB_TABLE = 'job_attachments';
    const DB_TABLE_PK = 'id';

    public $id;
    public $job_id;
    public $file;

}

?>