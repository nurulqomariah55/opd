<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Employee extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function get($no_badge = FALSE)
	{
		if ($no_badge === FALSE)
		{
			$this->db->select('no_badge,name');
			$this->db->from('employee');
			$this->db->order_by('name', 'ASC');
			return $query =  $this->db->get()->result();
		}
		
			$query = $this->db->where('employee', array('no_badge' => $no_badge));
			return $query =  $this->db->get()->result();
	}
	
	public function add($no_badge = FALSE)
	{
		$data = array(
			'no_badge' => $this->input->post('no_badge'),
			'name' => $this->input->post('name')
		);
		return $this->db->insert('employee', $data);
	}
	public function update($no_badge = FALSE)
	{
		$data = array(
			'no_badge' => $this->input->post('no_badge'),
			'name' => $this->input->post('name')
		);
		$this->db->where('no_badge', $no_badge);
		return $this->db->update('employee', $data);
	}
	public function delete($no_badge = FALSE)
	{		
		return $this->db->delete('employee', array('no_badge'=>$no_badge));
	}
}
?>