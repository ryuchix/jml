<?php

class Job_notes_model extends MY_Model
{
    const DB_TABLE = 'job_notes';
    const DB_TABLE_PK = 'id';

    public $id;
    public $job_id;
    public $note;
    public $added_by;


    function get_note_with_attachment($job_id)
    {
    	$attachment_query = "SELECT n.job_id, a.id AS file_id, n.id AS note_id, n.note, a.file
								FROM job_note_attachments AS a
									JOIN job_notes AS n ON a.note_id = n.id
					            Where n.job_id = ?";

	    $notes_query = "SELECT n.job_id, n.id AS note_id, n.note, 
					CONCAT(u.first_name, ' ', u.last_name) AS user
				FROM job_notes AS n
					JOIN users AS u ON u.id = n.added_by
	            Where n.job_id = ?";

    	$notes  = $this->db->query($notes_query, [$job_id])->result();

    	$attachments = $this->db->query($attachment_query, [$job_id])->result();

    	$ret = array();

    	foreach ($notes as $note) {
    		$n = array();
    		$n['job_id'] 	= $note->job_id;
    		$n['note_id'] 	= $note->note_id;
    		$n['note'] 		= $note->note;
    		$n['user'] 		= $note->user;
    		$n['files'] 	= array();
    		$ret[$note->note_id] = $n;
    	}

    	foreach ($attachments as $attachment) {
    		$ret[$attachment->note_id]['files'][$attachment->file_id] = $attachment->file;
    	}
    	return $ret;
    }

}

?>