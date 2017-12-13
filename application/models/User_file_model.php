<?php

/**
 * User File Model
 */
class User_file_model extends MY_Model
{
    const DB_TABLE = 'user_file';
    const DB_TABLE_PK = 'id';

    public $id;
    public $user_id;
    public $filename;
    public $document_type;
    public $description;
    public $image = '';
    public $active = 1;
    public $added_by;
    public $updated_by;

}

?>