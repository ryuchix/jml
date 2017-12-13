<?php

/**
 * USER MODAL
 */
class Client_model extends MY_Model
{
    const DB_TABLE = 'client';
    const DB_TABLE_PK = 'id';

    public $id;
    public $name;
    public $client_type;
    public $lead_type;
    public $phone;
    public $email;
    public $website = null;
    public $strata_plan = null;
    public $is_parent = 1;
    public $is_prospect = 0;
    public $child_of = null;
    public $address_1 = '';
    public $address_2 = null;
    public $address_state;
    public $address_long_state;
    public $address_suburb;
    public $address_post_code;
    public $address_location;
    public $same_billing_address;
    public $attention;
    public $co = null;
    public $address_street;
    public $billing_address_street;
    public $billing_address_1 = null;
    public $billing_address_2 = null;
    public $billing_state = null;
    public $billing_long_state = null;
    public $billing_suburb = null;
    public $billing_post_code = null;
    public $billing_address_location = null;
    public $active = 1;

    function get_count($prospect=0)
    {
        $this->db->where('active', 1);
        $this->db->where('is_prospect', $prospect);
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                // $this->getWhere(array('active'=>$active, 'is_prospect'=>0))
                $this->getWhere(array('active'=>$active))
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_list_where($active=1, $prospect=0)
    {
        $sql = "SELECT c.id, c.name, c.phone, c.active, c.email, c.address_1, c.address_suburb, c.address_post_code, c.is_parent, cp.name AS parent_name
                FROM client AS c
                    LEFT JOIN client AS cp ON c.child_of = cp.id
                WHERE c.active = $active AND c.is_prospect = $prospect";
        return $this->db->query($sql)->result();
    }

}

?>