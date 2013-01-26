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
		public $facebook;
     function __construct(){
	 	parent::__construct();
	 	$this->load->model('invitation_model','invitations');
	 	$this->load->helper("Facebook");

	 	$this->facebook = new dFacebook(false);
	 }

	public function index()
	{
		if($this->session->userdata('id')){
		redirect("/app/my_invitations");
		}else{
		$this->landing_page();
		}
	}
	public function landing_page(){
		//echo "Landing Page";
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "";
			$page_data['page_heading'] = "";
			$page_data['invitations'] = $this->invitations->list_invitations_merged();
		$this->output('app/landing_page',$page_data,'default_full_size');			
	}
	public function browse_invitations(){
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "Browse Invitations";
			$page_data['page_heading'] = "Browse Invitations";
			$page_data['invitations'] = $this->invitations->list_invitations_merged();
		$this->output('app/browse_invitations',$page_data);			
	}
	public function get_ideas(){
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "Get Invitation Invitations";
			$page_data['page_heading'] = "Get Invitation Invitations";
			$page_data['invitations'] = $this->invitations->list_customer_invitations_merged();
		$this->output('app/get_ideas',$page_data);			
	}
	public function my_invitations(){
		$this->_redirect_if_not_logged_in();
		$page_data = $this->page_data_base();
			$page_data['page_title'] = "Dashboard";
			$page_data['page_heading'] = "Dashboard";
			$page_data['invitations'] = $this->invitations->list_invitations($this->session->userdata('id'));
			$page_data['my_invitations'] = $this->invitations->list_my_invitations($this->session->userdata('id'));
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
	public function add_name($invitation_id,$name){
		$return_data = array();
		//add the name to the database
		$return_data['id'] = $this->invitations->add_name(urldecode($name),$invitation_id,$this->session->userdata('id'));

		//send back down the names block.

		$invitation = $this->invitations->get_personalised_invitation($invitation_id);
		if(!$invitation){
			$this->_invalid_page();
		}
		$names_html = "";
		foreach($invitation['names'] as $n){
		
			$base_path = "/app/finished_invitation/{$invitation['id']}/{$n['person_name']}";
			$preview_jpg = "<a href='$base_path/jpg/' target='_blank'>(Preview:Jpg)</a>";
			$preview_html = "<a href='$base_path/html/ target='_blank'>(Preview:Html)</a>";
		
			$names_html .= <<<HEREDOC
								<tr class='name_element' id='{$n['id']}'>
									<td>{$n['person_name']}</td>
									<td>{$preview_html} {$preview_jpg} <a class='remove close' id='remove_{$n['id']}'>x</a></td>
								</tr>
HEREDOC;
		}
		$return_data['names_block'] = $names_html;
		echo json_encode($return_data);
	}
	public function delete_name($id,$invitation_id){
		return $this->invitations->delete_name($id,$invitation_id,$this->session->userdata('id'));	
	}
	public function facebook_connect($invitation_id){
	//$this->load->helper('facebook');
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
		//if($this->session->userdata('id') || $this->facebook->getUser()){
		{
			$owner_id = $this->session->userdata('id') ? $this->session->userdata('id') : $this->facebook->getUser();
			$new_id = $this->invitations->start_invitation_from($invitation_id,$owner_id);

			redirect("/app/personalise_invitation/$new_id");
		}
		/*else{
			redirect("/app/facebook_connect/$new_id");
		}*/
	}
	public function view_invitation($invitation_id){
			$page_data = $this->page_data_base();
			if(!$this->invitations->user_owns_invitation($this->session->userdata('id'),$invitation_id)){
				$page_data['edit_disabled'] = true;
			}else{
				$page_data['edit_disabled'] = false;
			}
			
			$page_data['invitation'] = $this->invitations->get_invitation($invitation_id);
			$page_data['page_title'] = "View invitation: " . $page_data['invitation']['name'];
			$page_data['page_heading'] = "View Invitation: " . $page_data['invitation']['name'];
			if(!$page_data['invitation']){
				$this->_invalid_page();
			}
			$this->output('app/view_invitation',$page_data);			
	}
	public function personalise_invitation($p_id){
			$invitation = $this->invitations->get_personalised_invitation($p_id);
			if(!$invitation){
				$this->_invalid_page();
			}
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Personalise invitation";
			$page_data['page_heading'] = "Personalise Invitation";
			/*if(!$this->invitations->user_owns_invitation($this->session->userdata('id'),$invitation_id)){
				$page_data['edit_disabled'] = true;
			}else{
				$page_data['edit_disabled'] = false;
			}*/
			
			$page_data['invitation'] = $invitation;

			$this->output('app/personalise_invitation',$page_data);			
	}
	public function finished_invitation($p_id,$name,$format="html"){
			$page_data = $this->page_data_base();
			$page_data['page_title'] = "Personalise invitation";
			$page_data['page_heading'] = "Personalise Invitation";
		$page_data['invitation'] = $this->invitations->get_personalised_invitation($p_id);
		if(!$page_data['invitation']){
			$this->_invalid_page();
		}
		//overwrite the name field with that supplied.
		foreach($page_data['invitation']['fields'] as &$f){
			if($f['field_name'] == "name"){
				$f['value'] = urldecode($name);
			}
		}
		
		//echo json_encode($page_data);
		if($format == "html"){
		$this->output('app/finished_invitation',$page_data,'scripts_and_content');
		}
		else{
			//echo "JPG:";
			//exec($command . ' 2>&1',$output);

			//set POST variables
			$url = "http://www.screenshotter.dev";
			$fields = array(
									'page_to_download'=>urlencode("http://www.invites.dev/app/finished_invitation/$p_id/$name/html"));
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.''; }
			//rtrim($fields_string,'&');
			//echo $fields_string;
			//die();
			//open connection

			$image_url ='http://www.invites.dev/app/finished_invitation/' . $p_id . '/' . $name;
			$exec_string = '~/phantomjs /Users/rrrhys/projects/invites_ci/test.js '.$image_url . ' "#invitation_preview_merged" "'.$p_id.'_'.$name.'.jpg" 2>&1';
			exec($exec_string,$result);
			$result = implode("\r\n", $result);
			$result_obj = json_decode($result);
			echo json_encode($result_obj);
			echo "<img src='".'/invitations/'.$result_obj->filename."' />";
			//$this->output->set_content_type('jpeg');
    	//	$this->output->set_output(file_get_contents());
			//echo "OK";
		}
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
						redirect("/app/my_invitations");	
				}else if ($this->invitations->update_invitation($invitation_id,$invitation)){
						$this->session->set_flashdata('good','Invitation edited successfully.');
						redirect("/app/my_invitations");					
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
			array(	'name'=>$this->input->post("name"),
					'invitation_html'=>$this->input->post("invitation_html"),
					'orientation'=>$this->input->post("orientation")))){
						$this->session->set_flashdata('good','New Invitation added.');
						redirect("/app/my_invitations");
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