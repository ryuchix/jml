<?php

class Property_video_model extends MY_Model
{
    const DB_TABLE = 'property_video';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $title;
    public $description = null;
    public $url;
    public $active = 1;

}


?>

