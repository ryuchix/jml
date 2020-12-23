<?php

class Memo_model extends MY_Model
{
    const DB_TABLE = 'memo';
    const DB_TABLE_PK = 'id';

    public $id;
    public $title;
    public $description;
    public $file = '';
    public $active = 1;
    public $added_by;
    public $updated_by;

}

?>