<?php

/**
 * DAILY BALANCE MODAL
 */
class Daily_balance_model extends MY_Model
{
    const DB_TABLE = 'daily_balances';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $balance;
    public $notes;
    public $created_by;
    // public $added_time;
    public $updated_by;
    // public $updated_time;

    public function get_progress()
    {
        $last_30_days = date('Y-m-d', strtotime('-30 days'));

        $query = $this->db->query("SELECT * FROM `" . self::DB_TABLE . "` WHERE `date` >= '$last_30_days' ORDER BY `date`");

        return $query->result();
    }


    /**
     * Get an array of Models with an softing by date
     *
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = null, $offset = 0, $desc = true)
    {

        $query = $this->db->order_by('date', 'DESC')->get($this::DB_TABLE, $limit, $offset);

        $ret_val = array();

        $class = get_class($this);

        foreach ($query->result() as $row)
        {
            $model = new $class;

            $model->populate($row);

            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }

        return $ret_val;
    }


}

?>