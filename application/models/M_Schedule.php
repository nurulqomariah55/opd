<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Schedule extends CI_Model 
{
	public function getSchedule($id_schedule=false, $id_route=false)
	{
		if($id_schedule===false && $id_route===false)
		{
			$query = $this->db->get('schedule');
			return $query->result();
		}
		$this->db->select('r.id_route, r.route_name, l.id_location, l.location_name');
		$this->db->from('route r');
		$this->db->join('schedule s', 'r.id_route = s.id_route');
		$this->db->join('location l', 'l.id_location = s.id_location');
		$this->db->where('id_schedule', $id_schedule);
		$this->db->where('r.id_route', $id_route);
		$this->db->order_by('cast(id_order as unsigned) ASC', 'id_order ASC');
		return $query = $this->db->get()->result();
	}
	public function varSchedule($id_route=false){
		$this->db->select('r.id_route, count(distinct id_schedule) as jumlah');
		$this->db->from('schedule s');
		$this->db->join('route r','r.id_route = s.id_route');
		$this->db->group_by('s.id_route');
		$this->db->where('r.id_route', $id_route);
		return $query = $this->db->get()->result();
	}
	public function getSetting()
	{
		$this->db->select('distinct (s.id_schedule) as id_schedule, s.id_route');
		$this->db->from('schedule s');
		$this->db->join('route r', 'r.id_route = s.id_route');
		$this->db->order_by('s.id_schedule, s.id_route');
		return $query =$this->db->get()->result();
	}
	public function maxVar($id_route=false){
		$this->db->select('max(id_schedule) as id_schedule');
		$this->db->from('schedule');
		$this->db->where('id_route', $id_route);
		return $query = $this->db->get()->result();
	}

	public function add(){
		$id_route = $this->input->post('id_route');
		$id_location = $this->input->post('id_location');
		$id_schedule = $this->maxVar($id_route);
		$id_schedule = $id_schedule[0]->id_schedule;
		if(count($id_location)===count(array_flip($id_location))){			
			foreach ($id_location as $key => $value) {
				if($value==""){
					continue;
				}
				$dataschedule = array(
					'id_route' => $id_route,
					'id_location' => $value,
					'id_order' => ($key+1),
					'id_schedule' =>  ($id_schedule+1)
				);
				$insert_schedule = $this->db->insert('schedule', $dataschedule);
			}
		}else{
			$this->session->set_flashdata('message','<div class ="alert alert-danger alert-dismissible fade show" role="alert">The location name is <strong>duplicate. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
			$insert_schedule = false;
		}
		return $insert_schedule;
	}
	public function get($id_route=false, $id_schedule=false)
	{
		if($id_route===false && $id_schedule===false)
		{
			$query = $this->db->get('schedule');
			return $query->result();
 		}
		$this->db->select('s.id_route, s.id_schedule, l.id_location, l.location_name');
		$this->db->from('schedule s');
		$this->db->join('location l', 'l.id_location = s.id_location');
		$this->db->where('s.id_schedule', $id_schedule);
		$this->db->where('s.id_route', $id_route);
		$this->db->order_by('cast(s.id_order as unsigned) ASC', 'id_order ASC');
		return $query = $this->db->get()->result();
	}
	public function delete($id_route=false, $id_schedule=false)
	{
		return $this->db->delete('schedule', array('id_route'=>$id_route,'id_schedule'=>$id_schedule));
	}
	public function update($id_route = FALSE, $id_schedule=FALSE)
	{ 
    	$security_patrol = $this->M_Security->list($id_route, $id_schedule);
    	// var_dump($security_patrol);
		$this->delete($id_route,$id_schedule);
		$id_location = $this->input->post('id_location');
		foreach ($id_location as $key => $value) {
			if($value==""){
					continue;
			}
			$data = array(
				'id_route' => $this->input->post('id_route'),
				'id_schedule' => $this->input->post('id_schedule'),
				'id_order' => ($key+1),
				'id_location' => $value
			);
			$insert_schedule = $this->db->insert('schedule', $data);
		}
    	$data_patrol=array();
    	if(!empty($security_patrol)){
	    	foreach ($security_patrol as $key => $sp) {
	    		$data_patrol[] = array(
	    			'no_badge' => $sp->no_badge,
	    			'patrol_date' => $sp->patrol_date,
	    			'id_route' => $sp->id_route,
	    			'id_schedule' => $sp->id_schedule
	    		);
	    	}
	    	$this->db->insert_batch('security_patrol', $data_patrol);
	    }
		return $insert_schedule;
	}
}
?>