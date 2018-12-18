<?php

/**
 * CLIENT TYPES MODAL
 */
class Property_keys_model extends MY_Model
{
    const DB_TABLE = 'property_keys';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $key_type_id;
    public $description;
    public $image = '';
    public $active = 1;
    public $internal_reference = null;
    public $added_by;
    public $updated_by;
    
}

?>