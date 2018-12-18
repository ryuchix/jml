<?php


class Client_marketing_log_model extends MY_Model
{
    const DB_TABLE = 'client_marketing_logs';
    const DB_TABLE_PK = 'id';

    public $id;
    public $client_id;
    public $note;
    // public $path;
    // public $created_at;
    public $added_by;

    public function __construct()
    {
        $this->load->model('Client_marketing_log_attachments_model');
    }

    public function add_attachments($files)
    {
        foreach ($files as $file) {
            $record = new Client_marketing_log_attachments_model();
            $record->log_id = $this->id;
            $record->file = $file;
            $record->save();
        }
    }

    function get_note_with_attachment($client_id)
    {
        $attachment_query = "SELECT l.client_id, a.id AS file_id, l.id AS note_id, l.note, a.file
                                FROM client_marketing_logs AS l
                                    JOIN client_marketing_logs_attachments AS a ON a.log_id = l.id
                                Where l.client_id = ?";

        $notes_query = "SELECT l.client_id, l.id AS log_id, l.note, l.added_time AS timestamp, 
                    CONCAT(u.first_name, ' ', u.last_name) AS user
                FROM client_marketing_logs AS l
                    JOIN users AS u ON u.id = l.added_by
                Where l.client_id = ?";

        $notes  = $this->db->query($notes_query, [$client_id])->result();

        $attachments = $this->db->query($attachment_query, [$client_id])->result();

        $ret = array();

        foreach ($notes as $note) {
            $n = array();
            $n['client_id']     = $note->client_id;
            $n['log_id']        = $note->log_id;
            $n['note']          = $note->note;
            $n['user']          = $note->user;
            $n['timestamp']     = $note->timestamp;
            $n['files']         = array();
            $ret[$note->log_id] = $n;
        }

        foreach ($attachments as $attachment) {
            $ret[$attachment->note_id]['files'][$attachment->file_id] = $attachment->file;
        }
        return $ret;
    }

}

?>