<?php

/**
 * Task MODAL
 */
class Task_model extends MY_Model
{
    const DB_TABLE = 'tasks';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $client_type;

}

?>