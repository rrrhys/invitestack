<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_field_defaults_to_invitations extends CI_Migration {

	public function up(){
		$fields = array(
			'field_defaults'=>array('type'=>'VARCHAR',
								'constraint'=>'1000')
			);
		$this->dbforge->add_column('invitations',$fields);
	}
	public function down(){
		$this->dbforge->drop_column('invitations', 'field_defaults');
	}
}