<?php 
/**
* HISTORY TABLE CREATION
*/
class Migration_create_history extends CI_Migration
{
	
	function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'=> 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increament' => TRUE
			),
			'context_id' => array(
				'type'=> 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'context' => array(
				'type'=> 'VARCHAR',
				'constraint' => 100,
			),
			'timestamp' => array(
				'type'=> 'TIMESTAMP',
				'default' => 'CURRENT_TIMESTAMP',
			),
			'user_id' => array(
				'type'=> 'INT',
				'constraint' => 11,
			),
			'ip' => array(
				'type'=> 'VARCHAR',
				'constraint' => 100,
			),
			'description' => array(
				'type'=> 'text'
			)
		));

		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('history');
	}

	function down()
	{
		$this->dbforge->drop_table('history');
	}
}

 ?>