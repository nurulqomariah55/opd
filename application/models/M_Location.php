<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Location extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function get($id_location = FALSE)
	{
		if ($id_location === FALSE)
		{
			$query = $this->db->get('location');
			return $query->result();
		}
			$query = $this->db->get_where('location', array('id_location' => $id_location));
			return $query->result();
	}
	
	public function add($id_location = FALSE)
	{
		$data = array(
			'id_location' => $this->input->post('id_location'),
			'location_name' => $this->input->post('location_name')
		);
		return $this->db->insert('location', $data);
	}
	public function update($id_location = FALSE)
	{
		$data = array(
			'id_location' => $this->input->post('id_location'),
			'location_name' => $this->input->post('location_name')
		);
		$this->db->where('id_location', $id_location);
		return $this->db->update('location', $data);
	}
	public function delete($id_location = FALSE)
	{		
		return $this->db->delete('location', array('id_location'=>$id_location));
	}
	public function get_patrol_perday($id_checkpoint = FALSE)
	{
		if ($id_checkpoint === FALSE)
		{
			$this->db->select('convert(time_location, date) as time_location');
			$this->db->distinct('time_location');
			$this->db->from('patrol');
			$this->db->join('location', 'patrol.id_location = location.id_location ');
			return $query = $this->db->get()->result();
		}
			$this->db->select('convert(time_location, date) as time_location');
			$this->db->distinct('time_location');
			$this->db->from('patrol');
			$this->db->join('location', 'patrol.id_location = location.id_location ');
			$this->db->where('id_checkpoint',$id_checkpoint);
			return $query = $this->db->get()->result();
	}

	public function count_patrol_perId($id_route=FALSE)
	{
		if ($id_route === FALSE)
		{
			$this->db->select('id_checkpoint, count(distinct convert(time_location, date)) as time_location');
			$this->db->from('patrol p');
			$this->db->join('location l', 'p.id_location = l.id_location ');
			$this->db->group_by('id_checkpoint');
			return $query = $this->db->get()->result();
		}
			$this->db->select('c.id_checkpoint, count(distinct convert(time_location, date)) as time_location');
			$this->db->from('patrol p');
			$this->db->join('location l', 'p.id_location = l.id_location ');
			$this->db->join('checkpoint c', 'c.id_checkpoint = p.id_checkpoint ');
			$this->db->group_by('c.id_checkpoint');
			$this->db->where('id_route',$id_route);
			return $query = $this->db->get()->result();
	}

	public function get_shift_perday($id_checkpoint = FALSE, $time_location = FALSE)
	{
		$this->db->select('convert(time_location, date) as time_location, shift');
		$this->db->distinct('shift');
		$this->db->from('patrol p');
		$this->db->join('location l', 'p.id_location = l.id_location');
		$this->db->where('id_checkpoint', $id_checkpoint);
		$this->db->where('convert(time_location, date) = ', nice_date($time_location, 'Y-m-d'));
		$this->db->order_by('shift', 'ASC');
		return $query = $this->db->get()->result();
	}
	public function get_data_pershift($id_checkpoint = FALSE, $time_location = FALSE)
	{
		$this->db->select('l.id_location, location_name, time_location, shift');
		$this->db->from('location l');
		$this->db->join('patrol p', 'l.id_location = p.id_location');
		$this->db->join('checkpoint c', 'p.id_checkpoint = c.id_checkpoint');
		$this->db->where('c.id_checkpoint', $id_checkpoint);
		$this->db->where('convert(time_location, date) = ', nice_date($time_location, 'Y-m-d'));
		$this->db->order_by('time_location', 'ASC');
		return $query = $this->db->get()->result();
	}
	public function get_min_max_timeshift($id_checkpoint = FALSE, $time_location = FALSE)
	{
		$this->db->select('min(time_location) as min, max(time_location) as max, shift');
		$this->db->from('location l');
		$this->db->join('patrol p', 'l.id_location = p.id_location');
		$this->db->join('checkpoint c', 'p.id_checkpoint = c.id_checkpoint');
		$this->db->where('c.id_checkpoint', $id_checkpoint);
		$this->db->where('convert(time_location, date) = ', nice_date($time_location, 'Y-m-d'));
		$this->db->group_by('shift');
		return $query = $this->db->get()->result();
	}
}
?>