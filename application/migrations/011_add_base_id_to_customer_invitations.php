<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_base_id_to_customer_invitations extends CI_Migration {

	public function up(){
		$field = array('base_id'=>array('type'=>'INT',
						'constraint'=>5));
		$this->dbforge->add_column('customer_invitations',$field);

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_column('customer_invitations','base_id');
	}
}