<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_field_field_type_to_invitation_fields extends CI_Migration {

	public function up(){
		$fields = array(
			'field_type'=>array('type'=>'VARCHAR',
								'constraint'=>'50')
			);
		//$this->dbforge->add_column('invitation_fields',$fields);
	}
	public function down(){
		//$this->dbforge->drop_column('invitation_fields', 'field_type');
	}
}