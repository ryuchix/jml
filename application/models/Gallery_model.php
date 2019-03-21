<?php

/**
 * GALLRY MODAL
 */
class Gallery_model extends MY_Model
{
    const DB_TABLE = 'gallery';
    const DB_TABLE_PK = 'id';

    public $id;
    public $gallery_type;
    public $context_id;
    public $context;
    public $name;
    public $description = '';
    public $active = 1;
    public $source = 'web';
    public $added_by;
    public $updated_by;
    
    public function pending_galleries()
    {
        $this->db->select('
            gallery.*, 
            gallery_type.type, 
            client.name, 
            CONCAT(property.address, " ", property.address_suburb, " ", property.address_state) AS address, 
            CONCAT(users.first_name, " ", users.last_name) AS user
        ')
            ->from('gallery')
            ->join('gallery_type', 'gallery_type.id = gallery.gallery_type')
            ->join('property', 'property.id = gallery.context_id AND gallery.context = "property"')
            ->join('client', 'client.id = property.client_id')
            ->join('users', 'users.id = gallery.added_by')
            ->where('gallery.source = "app" AND gallery.active = 0');

        return $this->db->get()->result();
    }

}