<?php

class Job_model extends MY_Model
{
    const DB_TABLE = 'job';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $property_id;
    public $job_category;
    public $job_description;
    public $job_type;
    public $start_date;
    public $end_date;
    public $duration;
    public $duration_schedule;
    public $start_time;
    public $end_time;
    public $visit_frequency;
    public $frequency;
    public $every_no_day;

    public $week_days;
    public $month_type;
    public $month_day_or_week;
    public $selected_day_of_month;

    public $notes;
    public $next_visit;
    public $closed;
    public $added_by;


    function get_lists()
    {
        $sql = "SELECT j.id, j.job_description,
                    CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code) AS address, 
                    c.name AS client, j.job_type, j.job_category,
                    SUM(li.total) AS value, j.closed, nv.date AS next_visit
                FROM job AS j
                    JOIN client AS c ON c.id = j.client_id
                    JOIN property AS p ON p.id = j.property_id AND p.client_id = c.id
                    JOIN job_services AS li ON li.job_id = j.id
                    LEFT JOIN (
                        SELECT x.id, x.job_id, MIN(x.date) AS date FROM job_visits AS x
                         WHERE x.completed = 0 GROUP BY x.job_id ORDER BY x.id ASC
                    ) AS nv ON nv.job_id = j.id
                    GROUP BY j.id";
        return $this->db->query($sql)->result();
    }

}

?>