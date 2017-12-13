<?php

class Vehicle_model extends MY_Model
{
    const DB_TABLE = 'vehicle';
    const DB_TABLE_PK = 'id';

    public $id;
    public $license_plate;
    public $model;
    public $make;
    public $year;
    public $vin_no;
    public $color;
    public $gas_type;
    public $garagge;
    public $assign_to;
    public $description = '';
    public $image = '';
    public $active = 1;
    
    public $finance_status = null;
    public $finance_company = null;
    public $finance_amount = null;
    public $finance_monthly_payment = null;
    public $finance_term = null;
    public $finance_end_date = null;
    public $finance_balloon = null;

    public $insurance_company = null;
    public $insurance_number = null;
    public $insurance_date = null;
    public $insurance_expiry_date = null;
    public $insurance_monthly_payment = null;
    public $insurance_notes = null;
    public $insurance_file = null;

    function get_consumable_ids_by_property_id($property_id)
    {
        $ret = array_map(
                function($o){ 
                    return $o->license_plate; 
                },
                $this->getWhere( array( 'property_id' => $property_id ) )
            );
        return $ret;
    }

}

?>