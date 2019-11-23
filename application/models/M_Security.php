<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Security extends CI_Model 
{
	public function add()
	{	
		//a = ['Ahmad', 'Ahmad'] b = ['Ahmad']
		if (count($this->input->post('employee'))===count(array_flip($this->input->post('employee')))){
		foreach ($this->input->post('employee') as $val) {
			$employee= explode("-",$val);	
			$data = array(
				'no_badge' => $employee[0],
				'patrol_date' => (date("Y-m-d H:i:s", strtotime($this->input->post('patrol_date')))),
				'id_route' => $this->input->post('route'),
				'id_schedule' => $this->input->post('id_schedule')
			);
			$query = $this->db->insert('security_patrol', $data);
			} 
		}else{
           $this->session->set_flashdata('message','<div class ="alert alert-danger alert-dismissible fade show" role="alert">The security name is <strong>duplicate. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
			$query = false;
		}
		return $query;
	}
	public function list($id_route=FALSE, $id_schedule=FALSE)
	{
		if($id_route==FALSE && $id_schedule==FALSE){
			$this->db->select('distinct(patrol_date) as patrol_date, id_route, id_schedule');
			$this->db->from('security_patrol');
			return $query =  $this->db->get()->result();	
		}
		$this->db->select('*');
		$this->db->from('security_patrol sp');
		$this->db->where('id_route', $id_route);
		$this->db->where('id_schedule', $id_schedule);
		return $query =  $this->db->get()->result();
	}
}
?>