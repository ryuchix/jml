<?php

/**
 * SERVICE MODAL
 */
class Bin_liner_detail_model extends MY_Model
{
    const DB_TABLE = 'bin_liner_detail';
    const DB_TABLE_PK = 'id';

    public $id;
    public $liner_id;
    public $setting_id;
    public $price;
    public $qty;
    public $total;

}

?>