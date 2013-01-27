<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_customer_invitations_table extends CI_Migration {

	public function up(){
		$this->dbforge->add_field(array(
			'id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE,
						'auto_increment'=>TRUE),
			'name'=>array('type'=>'VARCHAR',
								'constraint'=>'100'),
			'invitation_html'=>array('type'=>'varchar',
								'constraint'=>'10000'),
			'fields_entered'=>array('type'=>'varchar',
								'constraint'=>'1000',
								'default'=>'0')
			));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('customer_invitations');
		$this->dbforge->add_field(array(
			'id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE,
						'auto_increment'=>TRUE),
			'customer_invitation_id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE),
			'person_name'=>array('type'=>'VARCHAR',
								'constraint'=>'100')
			));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('customer_invitation_names');
	}
	public function down(){
		$this->dbforge->drop_table('customer_invitations');
		$this->dbforge->drop_table('customer_invitation_names');
	}
}