<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Route extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function get($id_route = false)
	{
		if($id_route === false)
		{
			$query = $this->db->get('route');
			return $query->result();
		}
		$this->db->select('id_route,route_name,standard_time');
		$query = $this->db->get_where('route', array('id_route' => $id_route));
		return $query->result();
	}

public function add()
	{
		$data = array(
			'id_route' => strtoupper($this->input->post('id_route')),
			'route_name' => $this->input->post('route_name'),
			'standard_time' => $this->input->post('standard_time')
		);
		return $this->db->insert('route', $data);
	}

	public function update($id_route = FALSE)
	{
		$data = array(
			'id_route' => strtoupper($this->input->post('id_route')),
			'route_name' => $this->input->post('route_name'),
			'standard_time' => $this->input->post('standard_time')
		);
		$this->db->where('id_route',$id_route);
		return $this->db->update('route', $data);
	}

	public function delete($id_route = FALSE)
	{
		return $this->db->delete('route', array('id_route'=>$id_route));
	}
}
?>