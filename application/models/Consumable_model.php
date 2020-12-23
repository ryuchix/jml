<?php

/**
 * USER MODAL
 */
class Consumable_model extends MY_Model
{
    const DB_TABLE = 'consumable';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $supplier_id;
    public $ref_code;
    public $description = '';
    public $price;
    public $unit_per_box;
    public $image;
    public $active = 1;
    public $added_by;
    public $updated_by;

    function get_dropdown_lists($first_empty=1, $active=1, $uniqueForProperty = false)
    {
        if ($uniqueForProperty) 
        {
            $this->load->model('Property_consumables_model');
            $consumables = (new Property_consumables_model())->getWhere(['property_id' => $uniqueForProperty]);

            if (is_array($consumables)) 
            {
                foreach ($consumables as $consumable) 
                {
                    $this->db->where('id !=', $consumable->consumable_id);
                }
            }
        }

        $this->db->order_by('name');

        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                $this->getWhere( array( 'active' => $active ) )
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

}

?>