<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_description_field_to_invitations extends CI_Migration {

	public function up(){
		$field = array('long_description'=>array('type'=>'varchar',
						'constraint'=>1000,'default'=>'(This is the long description)'));
		$this->dbforge->add_column('invitations',$field);

		//$this->dbforge->drop_column('invitations', 'field_defaults');

	}
	public function down(){
		$this->dbforge->drop_column('invitations','long_description');
	}
}