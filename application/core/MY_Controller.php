<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

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
	 public function page_data_base(){
	 		
			
			$fbuser = $this->facebook->getUser();
			$fblogout = $fbuser? $this->facebook->getLogoutUrl() : "";
			$avatar_url = "";
			$auth_level = 0;
			if($this->session->userdata('id')){
				$avatar_url =$this->session->userdata('gravatar_url') . "?s=20?d=mm";
				$auth_level = 2;
			}
			else if($fbuser){
				$avatar_url = $this->facebook->getAvatar();
				$auth_level = 1;
			}
		$page_array = array('page_title'=>"",
	 				 'page_heading'=>"",
	 				 'bad_flash'=>$this->session->flashdata('bad'),
	 				 'good_flash'=>$this->session->flashdata('good'),
	 				 'warning_flash'=>$this->session->flashdata('warning'),
	 				 'logged_in'=>$this->session->userdata('id'),
	 				 'fbprofile'=>$fbuser ? $this->facebook->api('/me') : null,
	 				 'fblogout'=>$fblogout,
	 				 'auth_level'=>$auth_level,
	 				 'avatar'=>$avatar_url);
	 	//echo json_encode($page_array);
	 	return $page_array;
	 }
	 function __construct(){
	 	parent::__construct();
	 	$this->load->library('session');
	 	$this->load->library('migration');
	 	$this->migration->version(9);
	 	if($this->migration->error_string()){
	 		echo $this->migration->error_string();
	 		die();
	 	}
	 	$this->load->helper('form');
	 	$this->load->model('auth_model','auth');
	 	$this->load->helper('url');
	 	$this->load->helper('cookie');
		$this->load->helper('facebook');
		if(strstr($_SERVER['SERVER_NAME'], ".dev")){
		$this->facebook = new Facebook(array(
		        'appId'  => '405646389459045',
		        'secret' => '43932d8fdd4ef2734e0d57f0c6990fe0',
		      ));
		  }
		  else{
		$this->facebook = new Facebook(array(
		        'appId'  => '407681932590520',
		        'secret' => '205ba94a2c713fe2192ba23888d4abc0',
		      ));		  	
		  }
	 }
	 //pass in the content view, the page data array used by CI views,
	 //and a template base name (Used for multiple 'types' of screens)
	 function output($view_name,$page_data,$template_base = "default"){

	 	switch($template_base){
	 		case("default"):
	 			
	 			$views['header'] = $this->load->view("header",$page_data,true);
	 			$views['footer'] = $this->load->view("footer",$page_data,true);
	 			$views['content'] = $this->load->view($view_name,$page_data,true);
	 			$this->load->view("default",array_merge($views,$page_data));
	 		break;
	 		case("scripts_and_content"):
	 			
	 			$views['header'] = $this->load->view("header",$page_data,true);

	 			$views['content'] = $this->load->view($view_name,$page_data,true);
	 			$this->load->view("scripts_and_content",array_merge($views,$page_data));
	 		break;
	 	}
	 }
	 public function _is_authorised(){
	 	if(!$this->session->userdata('id')){
	 		redirect("/auth/login");
	 	}
	 	return true;
	 }

	 public function _redirect_if_not_logged_in($redirect_url = "/auth/login"){
	 	if(!$this->session->userdata('id')){
			$this->session->set_flashdata('bad',"You need to be logged in to do that.");
			redirect($redirect_url);	
		}
	 }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */