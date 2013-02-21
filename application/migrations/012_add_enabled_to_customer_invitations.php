<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_enabled_to_customer_invitations extends CI_Migration {

	public function up(){
		$field = array('enabled_for_new_invitations'=>array('type'=>'BOOLEAN','default'=>TRUE));
		$this->dbforge->add_column('invitations',$field);

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_column('invitations','enabled_for_new_invitations');
	}
}