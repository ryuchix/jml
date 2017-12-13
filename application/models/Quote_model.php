<?php

/**
 * SERVICE MODAL
 */
class Quote_model extends MY_Model
{
    const DB_TABLE = 'quote';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $quote_no;
    public $ref_no;
    public $client_id;
    public $property_id;
    public $contact;
    public $sales_rep;
    public $frequency;
    public $amount;
    public $chance;
    public $service_id;
    public $status;
    public $last_contact;
    public $next_contact;
    public $expected_signoff;
    public $notes;
    public $file = null;
    public $date_won = null;
    public $date_lost = null;

    function get_lists($type=STATUS_PENDING, $withPostalCode=1)
    {
        if ($withPostalCode) {
            $address = "CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code)";
        }else{
            $address = "CONCAT(p.address, ', ', p.address_suburb)";
        }

        $sql = "SELECT q.id, q.quote_no, c.name AS client,
                    $address AS address,
                    q.file, q.status, q.chance, 
                    CONCAT(cc.contact_name, ' ', cc.surname) AS contact,
                    CONCAT(u.first_name, ' ', u.last_name) AS sales,
                    q.frequency,  q.amount AS value, q.next_contact, q.last_contact, q.expected_signoff, s.name AS service
                FROM quote AS q
                    JOIN client AS c ON c.id = q.client_id
                    JOIN property AS p ON p.id = q.property_id
                    JOIN contacts AS cc ON cc.id = q.contact
                    JOIN service AS s ON s.id = q.service_id
                    JOIN users AS u ON u.id = q.sales_rep
                WHERE q.status = $type";
        return $this->db->query($sql)->result();
    }

    function get_forcast($withPostalCode=1)
    {
        if ($withPostalCode) {
            $address = "CONCAT(p.address, ', ', p.address_suburb, ', ', p.address_post_code)";
        }else{
            $address = "CONCAT(p.address, ', ', p.address_suburb)";
        }
        $sql = "
            SELECT q.id, q.quote_no, c.name AS client, q.file,
                    $address AS address,
                    q.amount, DATE_FORMAT(q.expected_signoff, '%b-%y') AS month, DATE_FORMAT(q.expected_signoff, '%d') AS day, 
                    s.name AS service
            FROM quote AS q
                    JOIN client AS c ON c.id = q.client_id
                    JOIN property AS p ON p.id = q.property_id
                    JOIN service AS s ON s.id = q.service_id
                    WHERE q.status = 6 AND q.expected_signoff BETWEEN DATE_FORMAT(now(), '%Y-%m-01') AND LAST_DAY(DATE_ADD(now(), INTERVAL 11 MONTH))
        ";
        return $this->db->query($sql)->result();

    }

}

?>