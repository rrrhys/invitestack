<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

     function __construct(){
	 	parent::__construct();
	 	$this->load->model('invitation_model','invitations');
	 	
	 }

	public function index()
	{
		if($this->session->userdata('id')){
		redirect("/app/dashboard");
		}else{
		redirect("/app/browse_invitations");
		}
	}
	public function browse_invitations(){
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "Browse Invitations";
			$page_data['page_heading'] = "Browse Invitations";
			$page_data['invitations'] = $this->invitations->list_invitations_merged();
		$this->output('app/browse_invitations',$page_data);			
	}
	public function dashboard(){
		$this->_redirect_if_not_logged_in();
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "Dashboard";
			$page_data['page_heading'] = "Dashboard";
			$page_data['invitations'] = $this->invitations->list_invitations($this->session->userdata('id'));
		$this->output('app/dashboard',$page_data);		
	}

	public function get_personalised_id($base_id){

		echo $this->invitations->get_personalised_id($base_id);
	}
	public function edit_personalised_invitation($invitation_id){
		$invitation = $this->invitations->get_personalised_invitation($invitation_id);
		$page_data = $this->page_data_base();
		$page_data['page_title'] = "Personalise invitation";
		$page_data['page_heading'] = "Personalise Invitation";

	}
	public function facebook_connect($invitation_id){
	
		//send user off to connect with facebook.
		if($this->facebook->getUser()){
			redirect("/app/start_invitation_from/$invitation_id");

		}else{
		echo "You need to login to facebook";
		echo "<a href='".$this->facebook->getLoginUrl()."'>OK</a>";
	}
	}
	public function start_invitation_from($invitation_id){

		if(!$this->session->userdata('id')){
			//is user logged in with facebook?
		}
		if($this->session->userdata('id') || $this->facebook->getUser()){
			$owner_id = $this->session->userdata('id') ? $this->session->userdata('id') : $this->facebook->getUser();
			$new_id = $this->invitations->start_invitation_from($invitation_id,$owner_id);

			redirect("/app/personalise_invitation/$new_id");
		}
		else{
			redirect("/app/facebook_connect/$new_id");
		}
	}
	public function view_invitation($invitation_id){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "View invitation";
			$page_data['page_heading'] = "View Invitation";
			if(!$this->invitations->user_owns_invitation($this->session->userdata('id'),$invitation_id)){
				$page_data['edit_disabled'] = true;
			}else{
				$page_data['edit_disabled'] = false;
			}
			
			$page_data['invitation'] = $this->invitations->get_invitation($invitation_id);
			$this->output('app/view_invitation',$page_data);			
	}
	public function personalise_invitation($p_id){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Personalise invitation";
			$page_data['page_heading'] = "Personalise Invitation";
			/*if(!$this->invitations->user_owns_invitation($this->session->userdata('id'),$invitation_id)){
				$page_data['edit_disabled'] = true;
			}else{
				$page_data['edit_disabled'] = false;
			}*/
			
			$page_data['invitation'] = $this->invitations->get_personalised_invitation($p_id);
			$this->output('app/personalise_invitation',$page_data);			
	}
	public function finished_invitation($p_id,$name){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Personalise invitation";
			$page_data['page_heading'] = "Personalise Invitation";
		$page_data['invitation'] = $this->invitations->get_personalised_invitation($p_id);
		//overwrite the name field with that supplied.
		foreach($page_data['invitation']['fields'] as &$f){
			if($f['field_name'] == "name"){
				$f['value'] = $name;
			}
		}
		
		//echo json_encode($page_data);
		$this->output('app/finished_invitation',$page_data,'scripts_and_content');
	}
	public function save_personalised_invitation($id){
		$invitation = array();
		$invitation['invitation_html'] = $this->input->post('invitation_html');
		$invitation['fields']= array();
			foreach($_POST as $k=>$v){
				if(substr($k, 0,12) == "input_merge_"){
					$k = substr($k,12);
					$invitation['fields'][$k] = array(
													'value' => $v,
													'type'=>"merge");
				}
				if(substr($k, 0,15) == "input_template_"){
					$k = substr($k,15);
					$invitation['fields'][$k] = array(
													'value' => $v,
													'type'=>"template");
				}
			}
		$this->invitations->update_personalised_invitation($id,$invitation);

		redirect("/app/personalise_invitation/$id");
		
	}
	public function edit_invitation($invitation_id){
		$this->_redirect_if_not_logged_in();
		if(!$this->input->post("submitted")){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Edit invitation";
			$page_data['page_heading'] = "Edit Invitation";
			$page_data['edit_disabled'] = false;
			$page_data['invitation'] = $this->invitations->get_invitation($invitation_id);
			$this->output('app/edit_invitation',$page_data);
			}else{
			$invitation = array();
			$invitation['name'] = $this->input->post('name');
			$invitation['invitation_html'] = $this->input->post('invitation_html');
			$invitation['fields']= array();
			foreach($_POST as $k=>$v){
				if(substr($k, 0,12) == "input_merge_"){
					$k = substr($k,12);
					$invitation['fields'][$k] = array(
													'value' => $v,
													'type'=>"merge");
				}
				if(substr($k, 0,15) == "input_template_"){
					$k = substr($k,15);
					$invitation['fields'][$k] = array(
													'value' => $v,
													'type'=>"template");
				}
			}

				if(!$this->invitations->user_owns_invitation($this->session->userdata('id'),$invitation_id)){
						$this->session->set_flashdata('bad',"User cannot edit that invitation.");
						redirect("app/dashboard");	
				}else if ($this->invitations->update_invitation($invitation_id,$invitation)){
						$this->session->set_flashdata('good','Invitation edited successfully.');
						redirect("/app/dashboard");					
				}
				else{
						$this->session->set_flashdata('bad',implode("<br />", $this->timeclock->errors));
						redirect("app/edit_invitation/" . $job_id);					
				}
			}	
	}
	public function new_invitation(){
		$this->_redirect_if_not_logged_in();
		if(!$this->input->post("submitted")){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Add a new invitation";
			$page_data['page_heading'] = "New Invitation";
			
			$this->output('app/new_invitation',$page_data);		
		}else{
			if($this->invitations->add_invitation($this->session->userdata('id'),
			array('name'=>$this->input->post("name"),
					'invitation_html'=>$this->input->post("invitation_html")))){
						$this->session->set_flashdata('good','New Invitation added.');
						redirect("/app/dashboard");
					}
					else{
						$this->session->set_flashdata('bad',implode("<br />", $this->invitations->errors));
						redirect("app/new_invitation");
					}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */