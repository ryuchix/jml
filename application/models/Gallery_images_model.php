<?php


class Gallery_images_model extends MY_Model
{
    const DB_TABLE = 'gallery_images';
    const DB_TABLE_PK = 'id';

    public $id;
    public $gallery_id;
    public $title;
    public $description;
    public $image;
    
}

?>