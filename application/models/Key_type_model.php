<?php

/**
 * SERVICE MODAL
 */
class Key_type_model extends MY_Model
{
    const DB_TABLE = 'key_type';
    const DB_TABLE_PK = 'id';

    public $id;
    public $type;
    public $description;
    public $image = '';
    public $active = 1;
    public $added_by;
    public $updated_by;

}

?>