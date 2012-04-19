<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_owner_id_to_personalised_invitation extends CI_Migration {

	public function up(){
		$field = array('owner_id'=>array('type'=>'INT',
						'constraint'=>5,
						'unsigned'=>TRUE));
		$this->dbforge->add_column('customer_invitations',
			$field
			);

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_column('customer_invitations','owner_id');
	}
}