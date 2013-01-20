<?

class Invitation_model extends CI_Model 
{
	public $errors = array();
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /*function _user_owns_customer($customer_id,$owner_id){
    	log_message('error', 'timeclock_model->_user_owns_customer is not implemented.');
    	return true;
    }*/
    public function list_invitations($owner_id=false){
      if($owner_id){
    	 $this->db->where('owner_id',$owner_id);
      }
    	$q = $this->db->get('invitations')->result_array();
    	return $q;
    }
    public function delete_name($name_id,$invitation_id,$owner_id){
      $this->db->where('id',$name_id);
      //$this->db->where('owner_id',$owner_id);
      $this->db->where('customer_invitation_id',$invitation_id);
      $this->db->delete('customer_invitation_names');
      return true;
    }
    public function add_name($name,$invitation_id,$owner_id){
      //check the user owns this invite.
      $this->db->where('id',$invitation_id);
      $this->db->where('owner_id',$owner_id);
      $invitation = $this->db->get('customer_invitations');
      if($invitation){
        $insert = array('customer_invitation_id'=>$invitation_id,'person_name'=>$name);
        $this->db->insert('customer_invitation_names',$insert);
        return $this->db->insert_id();
        
      }else{
        return false;
      }
    }
    public function list_invitations_merged($owner_id=false){
      if($owner_id){
       $this->db->where('owner_id',$owner_id);
      }
      $q = $this->db->get('invitations')->result_array();
      foreach($q as &$inv){
         $this->db->where('invitation_id',$inv['id']);
        $inv['fields'] = $this->db->get('invitation_fields')->result_array();
        foreach($inv['fields'] as $f){
          $find_string = '{' . $f['field_type'] . ':' . $f['field_name'] .'}';
          //echo $find_string;
         $inv['invitation_html'] = str_replace($find_string, $f['value'], $inv['invitation_html']);
        }

      }
      return $q;
    }
    public function list_customer_invitations_merged($owner_id=false){
      if($owner_id){
       $this->db->where('owner_id',$owner_id);
      }
      $q = $this->db->get('customer_invitations')->result_array();
      foreach($q as &$inv){
         $this->db->where('invitation_id',$inv['id']);
        $inv['fields'] = $this->db->get('customer_invitation_fields')->result_array();
        foreach($inv['fields'] as $f){
          $find_string = '{' . $f['field_type'] . ':' . $f['field_name'] .'}';
          //echo $find_string;
         $inv['invitation_html'] = str_replace($find_string, $f['value'], $inv['invitation_html']);
        }

      }
      return $q;
    }
    public function list_my_invitations($owner_id){
              if($owner_id){
               $this->db->where('owner_id',$owner_id);
              }
              $q = $this->db->get('customer_invitations')->result_array();
              return $q;
    }


    public function user_owns_invitation($owner_id,$invitation_id){
      $this->db->where('owner_id',$owner_id);
      $this->db->where('id',$invitation_id);
      $q = $this->db->get('invitations')->result_array();
      return count($q) == 1;
    }
    public function get_invitation($invitation_id){
      $this->db->where('id',$invitation_id);
    	$q = $this->db->get('invitations')->row_array();
      if($q){
        $this->db->where('invitation_id',$q['id']);
        $q['fields'] = $this->db->get('invitation_fields')->result_array();
      }
    	return $q;
    }
    public function start_invitation_from($invitation_id,$owner_id){
      $this->db->where('id',$invitation_id);
      $q = $this->db->get('invitations')->row_array();
      unset($q['id']);
      unset($q['owner_id']);
      unset($q['long_description']);
      $q['owner_id'] = $owner_id;
      $q['base_id'] = $invitation_id;
      $this->db->insert('customer_invitations',$q);
      $new_id = $this->db->insert_id();

      //insert all the fields
      $this->db->where('invitation_id',$invitation_id);
      $q= $this->db->get('invitation_fields')->result_array();
      foreach($q as $field){
        unset($field['id']);
        $field['invitation_id'] = $new_id;
        $this->db->insert('customer_invitation_fields',$field);
      }

      return $new_id;
    }
    public function get_personalised_invitation($p_id){
      $this->db->where('id',$p_id);
      $q = $this->db->get('customer_invitations')->row_array();
      if($q){
        $this->db->where('invitation_id',$p_id);
        $q['fields'] = $this->db->get('customer_invitation_fields')->result_array();
        $this->db->where('customer_invitation_id',$p_id);
        $q['names'] = $this->db->get('customer_invitation_names')->result_array();
      }
      return $q;
    }
    public function update_personalised_invitation($p_id,$invitation){
      //echo $p_id;
      $updatable_columns = array('name','invitation_html');

      $update_array = array();
      foreach($updatable_columns as $updatable_column){
        if(isset($invitation[$updatable_column])){
          $update_array[$updatable_column] = $invitation[$updatable_column];
        }
      }
      $this->db->where('id',$p_id);
      $this->db->update('customer_invitations',$update_array);
      if($invitation['fields']){
        //user supplied some field defaults.
        $this->db->where('invitation_id',$p_id);
        $this->db->delete('customer_invitation_fields');
        foreach($invitation['fields'] as $f=>$v){

          $insert = array('invitation_id'=>$p_id,
                          'field_name'=>$f,
                          'value'=>$v['value'],
                          'field_type'=>$v['type']);
          $this->db->insert('customer_invitation_fields',$insert);
        }
        if(isset($invitation['names'])){
          foreach($invitation['names'] as $f){
            $insert = array('customer_invitation_id'=>$p_id,
                            'person_name'=>$f);
            $this->db->insert('customer_invitation_names',$insert);
          }
        }
      }
      return true;
    }
    public function update_invitation($invitation_id,$invitation){
      $updatable_columns = array('name','invitation_html');

    	$update_array = array();
      foreach($updatable_columns as $updatable_column){
        if(isset($invitation[$updatable_column])){
          $update_array[$updatable_column] = $invitation[$updatable_column];
        }
      }
      $this->db->where('id',$invitation_id);
      $this->db->update('invitations',$update_array);
      if($invitation['fields']){
        //user supplied some field defaults.
        $this->db->where('invitation_id',$invitation_id);
        $this->db->delete('invitation_fields');
        foreach($invitation['fields'] as $f=>$v){

          $insert = array('invitation_id'=>$invitation_id,
                          'field_name'=>$f,
                          'value'=>$v['value'],
                          'field_type'=>$v['type']);
          $this->db->insert('invitation_fields',$insert);
        }
      }
      return true;
    }
   	public function add_invitation($owner_id,$invitation){
      $invitation['owner_id'] = $owner_id;
      $this->db->insert('invitations',$invitation);
      return $this->db->insert_id();
    }
}