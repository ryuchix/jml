<?php

/**
 * SERVICE MODAL
 */
class Client_file_model extends MY_Model
{
    const DB_TABLE = 'client_file';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $filename;
    public $document_type;
    public $description;
    public $image = '';
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

}

?>