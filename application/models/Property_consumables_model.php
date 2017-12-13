<?php

/**
 * USER MODAL
 */
class Property_consumables_model extends MY_Model
{
    const DB_TABLE = 'property_consumables';
    const DB_TABLE_PK = 'id';

    public $id;
    public $property_id;
    public $consumable_id;
    public $markup;
    public $notes = '';
    public $soled_price_per_box;
    public $soled_price_per_unit;

}

?>