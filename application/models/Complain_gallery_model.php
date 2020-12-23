<?php

/**
 * CLIENT TYPES MODAL
 */
class Gallery_model extends MY_Model
{
    const DB_TABLE = 'gallery';
    const DB_TABLE_PK = 'id';

    public $id;
    public $gallery_type;
    public $property_id;
    public $name;
    public $description = '';
    public $active = 1;
    public $added_by;
    public $updated_by;
    
}

?>