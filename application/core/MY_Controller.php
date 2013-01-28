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
	 		
			
			
			$avatar_url = "";
			$auth_level = 0;
			if($this->session->userdata('id')){
				$avatar_url =$this->session->userdata('gravatar_url') . "?s=20?d=mm";
				$auth_level = 2;
			}
		
		if(strstr($_SERVER['SERVER_NAME'], ".dev")){
			$avatar_url = "";
		}
		$page_array = array('page_title'=>"",
	 				 'page_heading'=>"",
	 				 'bad_flash'=>$this->session->flashdata('bad'),
	 				 'good_flash'=>$this->session->flashdata('good'),
	 				 'warning_flash'=>$this->session->flashdata('warning'),
	 				 'logged_in'=>$this->session->userdata('id'),
	 				 'auth_level'=>$auth_level,
	 				 'avatar'=>$avatar_url,
	 				 'analytics_key'=>$this->config->config['analytics_key']);
	 	//echo json_encode($page_array);
	 	return $page_array;
	 }
	 function __construct(){
	 	parent::__construct();
	 	$this->load->library('session');
	 	$this->load->library('migration');
	 	$this->migration->version(11);
	 	if($this->migration->error_string()){
	 		echo $this->migration->error_string();
	 		die();
	 	}
	 	$this->load->helper('form');
	 	$this->load->model('auth_model','auth');
	 	$this->load->helper('url');
	 	$this->load->helper('cookie');

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
	 		case("default_full_size"):
	 			
	 			$views['header'] = $this->load->view("header",$page_data,true);
	 			$views['footer'] = $this->load->view("footer",$page_data,true);
	 			$views['content'] = $this->load->view($view_name,$page_data,true);
	 			$this->load->view("default_full_size",array_merge($views,$page_data));
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
	 public function _invalid_page(){
	 	redirect("/app");
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