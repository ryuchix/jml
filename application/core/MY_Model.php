<?php

class MY_Model extends CI_Model {
    const DB_TABLE = 'abstract';
    const DB_TABLE_PK = 'abstract';

    /**
     * Create record.
     */
    protected function insert($withoutPrimaryKey) {
        if ($withoutPrimaryKey) {
            $this->db->insert($this::DB_TABLE, $this);
        }else{
            $this->db->insert($this::DB_TABLE, $this);
            $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
            return $this->{$this::DB_TABLE_PK};
        }
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch($this::DB_TABLE, $data);
    }

    /**
     * Update record.
     */
    protected function update() {
        $this->db->update($this::DB_TABLE, $this, [$this::DB_TABLE_PK=>$this->{$this::DB_TABLE_PK}] );
        return ($this->db->affected_rows()>0)? $this->db->affected_rows(): FALSE;
    }

    /**
     * Populate from an array or standard class.
     * @param mixed $row
     */
    public function populate($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Load from the database.
     * @param int $id
     */
    public function load($id) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $id,
        ));
        if($row = $query->row())
            $this->populate($row);
        else 
            return false;
    }

    /**
     * Delete the current record.
     */
    public function delete() {
        $this->db->delete($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK},
        ));
        unset($this->{$this::DB_TABLE_PK});
        return $this->db->affected_rows();
    }

    /**
     * Delete the current record.
     */
    public function deleteWhere($filter = array()) {
        $this->db->delete($this::DB_TABLE, $filter);
        return $this->db->affected_rows();
    }


    /**
     * Save the record.
     */
    public function save($withoutPrimaryKey=false) {
        if ($withoutPrimaryKey) {
            return $this->insert($withoutPrimaryKey);
        }else{
            if (isset($this->{$this::DB_TABLE_PK})) {
                return $this->update();
            }
            else 
            {
                if( is_null($this->{$this::DB_TABLE_PK}) )
                unset($this->{$this::DB_TABLE_PK});
                return $this->insert($withoutPrimaryKey);
            }
        }
    }

    /**
     * Get an array of Models with an optional limit, offset.
     *
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = 500, $offset = 0,$desc=true) {
        if ($limit) {
            if ($desc)
                $query = $this->db->order_by($this::DB_TABLE_PK, 'DESC')->get($this::DB_TABLE, $limit, $offset);
            else
                $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }

        $ret_val = array();
        $class = get_class($this);

        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);

            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }


    /**
     * get Max Record.
     */
    public function max() {
        $this->db->select_max($this::DB_TABLE_PK,'max_val');
        $query = $this->db->get($this::DB_TABLE);
        $s = $query->result();
        $max = array_shift($s);
        return $max->max_val+1;
    }

    /**
     * get number of Unique Record.
     */
    public function max_where($column_name) {
        $this->db->select_max($column_name,'value');
        $query = $this->db->get($this::DB_TABLE);
        $max = array_shift($query->result());
        return $max->value+1;
    }

    /**
     * get COLUMN LIKE TERM Record.
     */
    public function getLike($term,$col,$where=false) {
        if ($where) {
            $this->db->select('*')->from($this::DB_TABLE)->where($where)->like($col,$term,'both');
            $query = $this->db->get();
        }else{
            $this->db->like($col,$term,'both');
            $query = $this->db->get($this::DB_TABLE);
        }
        return $query->result();
    }

    /**
     * get by column name Record.
     */
    public function getWhere($term,$first=false,$limit=500, $key_as_id = true) 
    {

        $query = $this->db->get_where($this::DB_TABLE,$term, ($limit==='*')?null:$limit );
        
        if ($first){
            return $query->row();
        }
        
        if (!$key_as_id) {
            return $query->result();
        }

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

    /**
     * get by column name Record.
     */
    public function where($query_string,$first=false,$limit=500) {
        // $this->db->where($col,$query_string); ASERIDJF SADKFJLKJKLjKJ  KASJDFLKJSDAFLKJSDALFKJASDLKFJAEWIFASJDF34343ASEFEDFEIASDJFLKASDFJEORJLSKDAJFLKJ35LKJDLKSFJ ASKLDFJALSKD FJELKR34ASKDJF 3
        $this->db->where($query_string);
        if ($limit!="*") {
            $this->db->limit($limit);
        }
        $query = $this->db->get($this::DB_TABLE);
        if ($first)
            return $query->row();
        else
            return $query->result();
    }

    public function count_where($term) {
        $this->db->where($term);
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }


    function get_count()
    {
        $this->db->where('active', 1);
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }


    function count()
    {
        $this->db->from($this::DB_TABLE);
        return $this->db->count_all_results();
    }

}




?>