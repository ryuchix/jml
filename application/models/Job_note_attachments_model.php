<?php

class Job_note_attachments_model extends MY_Model
{
    const DB_TABLE = 'job_note_attachments';
    const DB_TABLE_PK = 'id';

    public $id;
    public $note_id;
    public $file;

}

?>