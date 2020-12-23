<?php

/**
 * SERVICE MODAL
 */
class Client_note_model extends MY_Model
{
    const DB_TABLE = 'client_note';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $document_type;
    public $user_roles;
    public $notes;
    public $image = '';
    public $active = 1;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;
    // public $data_services;

}

?>