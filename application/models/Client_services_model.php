<?php

/**
 * USER MODAL
 */
class Client_services_model extends MY_Model
{
    const DB_TABLE = 'client_services';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $service_id;

}

?>