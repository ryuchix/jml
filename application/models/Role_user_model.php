<?php

/**
 *
 * USER ROLE MODAL
 *
 */

class Role_user_model extends MY_Model
{
    const DB_TABLE = 'role_user';

    const DB_TABLE_PK = 'user_id';

    public $user_id;

    public $role_id;
    
}
