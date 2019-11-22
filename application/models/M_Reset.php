<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Reset extends CI_Model 
{
	public function getUser($username=false)
	{
		$query = $this->db->get_where('user', array('username'=> $username));
		return $query->row_array();
	}

	public function checkForget()
	{
		$username = $this->input->post('username');
		$data = $this->getUser($username);
		$password = array(
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
		);
		if(empty($data)){
			echo "<script type='text/javascript'>alert(Username doesn't exist');</script>";
			redirect(base_url('forget'), 'refresh');
		}
		return $this->updatePassword($username, $password);
	}
	public function updatePassword($username=FALSE, $password=FALSE){
		if($username && $password){
			$this->db->where('username', $username);
			return $result=$this->db->update('user', $password);	
		}
	}
}
?>