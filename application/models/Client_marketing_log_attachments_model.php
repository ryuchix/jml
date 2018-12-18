<?php

class Client_marketing_log_attachments_model extends MY_Model
{
    const DB_TABLE = 'client_marketing_logs_attachments';
    const DB_TABLE_PK = 'id';

    public $id;
    public $log_id;
    public $file;

}

?>