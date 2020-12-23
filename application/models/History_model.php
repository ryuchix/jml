<?php

/**
 * USER MODAL
 */
class History_model extends MY_Model
{
    const DB_TABLE = 'history';
    const DB_TABLE_PK = 'id';

    public $id;
    public $context_id;
    public $context;
    public $description;
    public $action_by;

    function get_history_by_context_id($context_id, $context, $query_object=false)
    {
        // "Monday 8th of August 2005 03:12:46 PM";
        // "%W %D of %M %Y %I:%i:%s %r"
        return $this->get_history_by_context($context_id, $context, $query_object);
    }

    function get_history_by_context($context_id, $context, $query_object=false)
    {
        $sql = "SELECT h.description, u.user_name AS user, DATE_FORMAT(h.timestamp, '%W %D of %M %Y %r') AS time 
                    FROM history h 
                        JOIN users AS u 
                            ON u.id = h.action_by WHERE h.context_id = $context_id AND h.context = '$context'
                            ORDER BY h.timestamp DESC";

        $query = $this->db->query($sql);
        if( $query_object )
            return $query;
        else{
            $result = $query->result();
            return ( $result && !empty($result) )? $result: [];
        }
    }

}

?>