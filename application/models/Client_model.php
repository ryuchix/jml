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
    public $is_lead = 0;
    public $lead_date;
    public $lead_by = null;
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
    public $account_email = null;
    public $address_street = null;
    public $billing_address_street;
    public $billing_address_1 = null;
    public $billing_address_2 = null;
    public $billing_state = null;
    public $billing_long_state = null;
    public $billing_suburb = null;
    public $billing_post_code = null;
    public $billing_address_location = null;
    public $active = 1;

    public function authenticate($username,$password)
    {
        $this->db->where("active = 1 AND (username = '$username' OR email = '$username')");

        $this->db->limit(1);

        $query = $this->db->get(SELF::DB_TABLE);

        $user = $query->row();

        if ( $user && password_verify($password,$user->password) )
            return $user;
        
        return FALSE;
    }

    function get_count($prospect=0)
    {
        $this->db->where('active', 1);
        $this->db->where('is_prospect', $prospect);
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $this->db->order_by('name');

        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                // $this->getWhere(array('active'=>$active, 'is_prospect'=>0))
                $this->getWhere(array('active'=>$active))
            );
        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_list_where($active = 1, $prospect = 0, $lead = 0)
    {
        $sql = "SELECT c.id, c.name, c.phone, c.active, c.attention, ct.type AS client_type, c.email, c.address_1, c.address_suburb, c.address_post_code, c.is_parent, cp.name AS parent_name, lt.type AS lead_type, CONCAT(u.first_name, ' ', u.last_name) AS lead_by, c.lead_date
                FROM client AS c
                    LEFT JOIN client AS cp ON c.child_of = cp.id
                    LEFT JOIN client_type AS ct ON c.client_type = ct.id
                    LEFT JOIN lead_type AS lt ON c.lead_type = lt.id
                    LEFT JOIN users AS u ON c.lead_by = u.id
                WHERE c.active = $active AND c.is_prospect = $prospect AND c.is_lead = $lead";
        return $this->db->query($sql)->result();
    }

    public function get_filtered_list()
    {
        $client_or_prospect = (int)$this->input->get('client_or_prospect');

        $client_type = $this->input->get('client_type');
        
        $lead_type = $this->input->get('lead_type');
        
        $child_or_parent = (int)$this->input->get('child_or_parent');

        $is_active = (int)$this->input->get('is_active');

        $clients = $this->db
            ->select("c.id, 
                c.name, 
                c.client_type as client_type_id, 
                ct.type as client_type, 
                c.lead_type as lead_type_id, 
                lt.type as lead_type, 
                c.is_parent,
                CONCAT(c.address_1, ' ', c.address_suburb) as address"
                , FALSE)
            ->from('client as c')
            ->join('client_type as ct', 'ct.id = c.client_type')
            ->join('lead_type as lt', 'lt.id = c.lead_type');
        
        if ($client_or_prospect) 
        {
            if ($client_or_prospect === 1) {
                $clients->where('c.is_prospect', 0);
            }elseif ($client_or_prospect === 3) {
                $clients->where('c.is_lead', 1);
            }else{
                $clients->where('c.is_prospect', 1);
            }
        }
        
        if (is_numeric($client_type)) 
        {
            $clients->where('c.client_type', $client_type);
        }
        
        if (is_numeric($lead_type)) 
        {
            $clients->where('c.lead_type', $lead_type);
        }

        if ($child_or_parent) 
        {
            if ($child_or_parent === 1) // Only Parent
            { 
                $clients->where('c.is_parent', 1);
            }else{
                $clients->where('c.is_parent', 0);
            }
        }

        $clients->where('c.active', $is_active);

        return $clients->get()->result();
    }

    function contacts()
    {
        if (!$this->id) {
            return null;
        }
        $this->load->model('Contacts_model');
        return $this->Contacts_model->getWhere(['client_id' => $this->id]);
    }

}