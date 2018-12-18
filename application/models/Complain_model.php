<?php

/**
 * SERVICE MODAL
 */
class Complain_model extends MY_Model
{
    const DB_TABLE = 'complain';
    const DB_TABLE_PK = 'id';

    public $id;
    public $title;
    public $client_id;
    public $property_id;
    public $reported_by;
    public $complain_date;
    public $complain_taken_by = '';
    public $complain_details;
    public $first_response_corrective_action = '';
    public $suspected_cause = '';
    public $corrective_action_response = '';
    public $corrective_action_followup = '';
    public $step_to_avoid_same_issue = '';
    public $status = '';
    public $assigned_to;

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->name; 
                }, 

                $this->getWhere(array('active'=>1))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_complaints_list($status)
    {
        $sql = "SELECT i.id, i.title, c.name AS client, 
                    CONCAT(u.first_name, ' ', u.last_name) AS assigned, 
                    p.address, CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS property, 
                    i.status
            FROM complain AS i 
        JOIN users AS u ON u.id = i.assigned_to
        JOIN client AS c ON c.id = i.client_id
        JOIN property AS p ON p.id = i.property_id AND p.client_id = i.client_id
        WHERE i.status = $status";
        return $this->db->query($sql)->result();
    }

    function get_open_or_assinged_complaints_list()
    {
        $sql = "SELECT i.id, i.title, c.name AS client, 
                    CONCAT(u.first_name, ' ', u.last_name) AS assigned, 
                    p.address, CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS property, 
                    i.status
            FROM complain AS i 
        JOIN users AS u ON u.id = i.assigned_to
        JOIN client AS c ON c.id = i.client_id
        JOIN property AS p ON p.id = i.property_id AND p.client_id = i.client_id
        WHERE i.status = " . STATUS_OPEN . " OR i.status = " . STATUS_ASSIGNED;
        return $this->db->query($sql)->result();
    }

    public function count_open_or_assigned($client_id = false) {
        
        if ($client_id) 
        {
            $this->db->where(['client_id' => $client_id]);
        }

        $this->db->where(['status'=>STATUS_OPEN]);
        $this->db->or_where(['status'=>STATUS_ASSIGNED]);
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }


}

?>