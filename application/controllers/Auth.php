<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->form_validation->set_rules('username','username','trim|required');
		$this->form_validation->set_rules('password','password','trim|required');
		if($this->form_validation->run() == false){
		$data['title'] ='Login';
		$this->load->view('templates/header', $data);
		$this->load->view('auth/login');
		$this->load->view('templates/footer-login');
	} else {
		//validasinya success
		$this->_login();
	
	}
}
private function _login()
{
	$username = $this->input->post('username');
	$password = $this->input->post('password');
	$user = $this->db->get_where('user',['username' => $username])->row_array();
//jika usernya ada
	if($user){
			//cek password
			if(password_verify($password, $user['password'])){
				$data = [
					'username'=> $user['username'],
				];
				$this->session->set_userdata($data);
				redirect('dashboard');
			}else{
				$this->session->set_flashdata('message','<div class ="alert alert-danger" role="alert">Wrong password!</div>');
				redirect();
			}
		}else{
			$this->session->set_flashdata('message','<div class ="alert alert-danger" role="alert">Wrong username! </div>');
			redirect();
	}
}
	public function reset_password()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','username', 'required');
		$this->form_validation->set_rules('password','new password', 'required');
		$this->form_validation->set_rules('confirm-password','confirm password', 'required|matches[password]');
		if($this->form_validation->run()== false)
		{
			$data['title']="Forgot password";
			$this->load->view('templates/header',$data);
			$this->load->view('auth/reset_password');
			$this->load->view('templates/footer-forgot');
		}else
		{
			if($this->M_Reset->checkForget()){				
			$this->session->set_flashdata('message','<div class ="alert alert-success" role="alert">The password has been changed!</div>');
			redirect(base_url('forget'));
			}
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('data');
		$this->session->set_flashdata('message','<div class ="alert alert-success" role="alert">You have been logged out!</div>');
			redirect();
	}
}