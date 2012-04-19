<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_orientation_to_all_invitations extends CI_Migration {

	public function up(){
		$field = array('orientation'=>array('type'=>'varchar',
						'constraint'=>100,'default'=>'portrait'));
		$this->dbforge->add_column('customer_invitations',$field);
		$this->dbforge->add_column('invitations',$field);

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_column('invitations','orientation');
		$this->dbforge->drop_column('customer_invitations','orientation');
	}
}