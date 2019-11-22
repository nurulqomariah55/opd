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
}
?>