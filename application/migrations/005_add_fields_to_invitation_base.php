<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fields_to_invitation_base extends CI_Migration {

	public function up(){
		$this->dbforge->add_field(array(
			'id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE,
						'auto_increment'=>TRUE),

						'invitation_id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE),
			'field_name'=>array('type'=>'VARCHAR',
								'constraint'=>'100'),
			'field_type'=>array('type'=>'VARCHAR',
								'constraint'=>'50'),
			'value'=>array('type'=>'VARCHAR',
								'constraint'=>'100')
			));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('invitation_fields');

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_table('invitation_fields');
	}
}