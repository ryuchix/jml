<?php

/**
 * PERMISSION MODAL
 */
class Permission_model extends MY_Model
{
    const DB_TABLE = 'permissions';

    const DB_TABLE_PK = 'id';

    public $id;

    public $label;

    public $name;

    public $display_group;
    
}
