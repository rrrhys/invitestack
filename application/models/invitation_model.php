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
    public function get_generic_image_url($invitation_id,$size="thumb",$force_remake = false){
      log_message('debug', '(get_generic_image_url)asked to make generic image for id ' . $invitation_id . $size);
      $web_path = $this->make_generic_image_if_not_exists($invitation_id,"John",date("dMY"),$size,$force_remake);
      return $web_path;
    }
    public function make_generic_image_if_not_exists($invitation_id,$invitation_name,$unique_hash="1",$size="thumb",$force_remake = false){
      log_message('debug', '(make_generic_image_if_not_exists) for id ' . $invitation_id);
      $image_url ="http://".$_SERVER['HTTP_HOST'] . '/app/generic_invitation/' . $invitation_id . '/' . $invitation_name . '/' . $unique_hash . '/html/' . $size;
      $filename_to_make = "Generic_".$invitation_id.'_'.$invitation_name.'_'.$unique_hash . $size.'.jpg';
      $exec_string = $this->config->config['phantomjs_path'] .'/phantomjs '.$_SERVER['DOCUMENT_ROOT'] . '/test.js '.$image_url . ' "#invitation_preview_merged" "'.$_SERVER['DOCUMENT_ROOT'].'/invitations/'.$filename_to_make.'" 2>&1';
      //echo $exec_string;
      $web_path = "/invitations/".$filename_to_make;

      if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/invitations/'.$filename_to_make) || $force_remake){
         log_message('debug', '(make_generic_image_if_not_exists) calling ' . $exec_string);
      exec($exec_string,$result);
      //echo json_encode($result);
      $result = implode("\r\n", $result);
      $result_obj = json_decode($result);
      
      $real_path = $result_obj->filename;
      //echo $real_path;
      }
      return $web_path;
    }
    public function get_image_url($invitation_id,$size="thumb"){
      $web_path = $this->make_image_if_not_exists($invitation_id,"John",date("dMY"),$size);
      return $web_path;
    }
    public function make_image_if_not_exists($invitation_id,$invitation_name,$unique_hash="1",$size="thumb"){
      $image_url ="http://".$_SERVER['HTTP_HOST'] . '/app/finished_invitation/' . $invitation_id . '/' . $invitation_name . '/' . $unique_hash . '/html/' . $size;
      $filename_to_make = $invitation_id.'_'.$invitation_name.'_'.$unique_hash . $size.'.jpg';
      $exec_string = $this->config->config['phantomjs_path'] .'/phantomjs '.$_SERVER['DOCUMENT_ROOT'] . '/test.js '.$image_url . ' "#invitation_preview_merged" "'.$_SERVER['DOCUMENT_ROOT'].'/invitations/'.$filename_to_make.'" 2>&1';
      //echo $exec_string;
      $web_path = "/invitations/".$filename_to_make;

      if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/invitations/'.$filename_to_make)){
      exec($exec_string,$result);
      //echo json_encode($result);
      $result = implode("\r\n", $result);
      $result_obj = json_decode($result);
      
      $real_path = $result_obj->filename;
      //echo $real_path;
      }
      return $web_path;
    }
    public function list_invitations_merged($owner_id=false){
      log_message('debug', 'list invitations merged called');
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
        log_message('debug', '(list_invitations_merged) need generic image for id ' . $inv['id']);
        $inv['image_url_thumb'] = $this->get_generic_image_url($inv['id'],"thumb");
        $inv['image_url_print'] = $this->get_generic_image_url($inv['id'],"print");
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
    public function get_invitation($invitation_id,$skip_url = true,$force_remake = false){
      $this->db->where('id',$invitation_id);
    	$q = $this->db->get('invitations')->row_array();
      if($q){
        $this->db->where('invitation_id',$q['id']);
        $q['fields'] = $this->db->get('invitation_fields')->result_array();
        if(!$skip_url){
          $q['image_url_thumb'] = $this->get_generic_image_url($q['id'],"thumb",$force_remake);
          $q['image_url_print'] = $this->get_generic_image_url($q['id'],"print",$force_remake);
        }
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
      $updatable_columns = array('name','invitation_html','long_description');

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
      //invitation was updated - delete the cached images.
      $inv = $this->get_invitation($invitation_id,false,true);

      return true;
    }
   	public function add_invitation($owner_id,$invitation){
      $invitation['owner_id'] = $owner_id;
      $this->db->insert('invitations',$invitation);
      return $this->db->insert_id();
    }
}