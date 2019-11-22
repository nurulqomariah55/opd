<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Checkpoint extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	} 
	public function save()
	{
		$data = $this->session->data;
		$id_location=array();
		$time_location=array();
		$data_patrol=array();
		$checkDate = $this->checkDate((substr($data['route'],6,1)),date('Y-m-d',strtotime($data['date_first'])));   
		// var_dump($checkDate);
		if($checkDate[0]->id_checkpoint==NULL){			
			$data_checkpoint = array(
				'id_checkpoint' => '',
				'id_collector'  => $data['collector'],
				'first_check'   => date('Y-m-d H:i:s',strtotime($data['date_first'] .' '. $data['hour_first'])),
				'last_check'    => date('Y-m-d H:i:s',strtotime($data['date_last'] .' '. $data['hour_last'])),
				'id_route'      => substr($data['route'],6,1)
				);
			$count=0;
			foreach ($data['time_location'] as $dt){
				$time_location[]=$dt;
			}
			$count=0;
			foreach ($data['id_location'] as $dt) {
				$id_location[]=$dt;
			}
			$count=0;
			$this->db->insert('checkpoint', $data_checkpoint);
			$id_checkpoint = $this->db->insert_id();

			$shift = 1;
			for ($i=0; $i < sizeof($id_location); $i++) {
				if(($count>1 && $data['date_shift'][$count]!=$data['date_shift'][$count-1])){
					$shift=1;
				}
				if ($id_location[$i]==$data['id_finish']) {
					$data_patrol[]=array(
					'id_checkpoint' => $id_checkpoint,
					'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count++]." ".$time_location[$i])),
					'id_location' => $id_location[$i],
					'shift' => $shift++,
					);

				}else{
					$data_patrol[]=array(
					'id_checkpoint' => $id_checkpoint,
					'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count]." ".$time_location[$i])),
					'id_location' => $id_location[$i],
					'shift' => $shift,
					);
				}
			}
			$this->db->insert_batch('patrol', $data_patrol);
		}else{
			foreach ($data['time_location'] as $dt){
				$time_location[]=$dt;
			}
			foreach ($data['id_location'] as $dt) {
				$id_location[]=$dt;
			}
			$count=0;
			$countDuplicate=0;
			$countFirst=0;
			$last_shift = $this->getLastShift((substr($data['route'],6,1)),$checkDate[0]->id_checkpoint, date('Y-m-d',strtotime($data['date_first'])));
			$shift = $last_shift[0]->last_shift+1;
			$diff=0;
			for ($i=0; $i < sizeof($id_location); $i++) {
				if($count>1){
					// echo $count;
					$diff = date_diff(date_create($data['date_shift'][$count]), date_create($data['date_shift'][$count-1]));
					$diff = $diff->format('%a');
				}
				if($diff==1 && $countDuplicate==0 ){
					$data_checkpoint=array(
						'last_check' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count-1]." ".$time_location[$i-1])),
					);
					$this->db->where('id_checkpoint', $checkDate[0]->id_checkpoint);
					$this->db->update('checkpoint', $data_checkpoint);
					$countDuplicate++;
				}else if($data['date_shift'][$count]==$data['date_first']){
					if ($id_location[$i]==$data['id_finish']) {
						$data_patrol[]=array(
						'id_checkpoint' => $checkDate[0]->id_checkpoint,
						'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count++]." ".$time_location[$i])),
						'id_location' => $id_location[$i],
						'shift' => $shift++,
						);

					}else{
						$data_patrol[]=array(
						'id_checkpoint' => $checkDate[0]->id_checkpoint,
						'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count]." ".$time_location[$i])),
						'id_location' => $id_location[$i],
						'shift' => $shift,
						);
					}
				}else if($data['date_shift'][$count]!=$data['date_first'] && $countFirst==0){
					$first_check=date('Y-m-d H:i:s',strtotime($data['date_shift'][$count]." ".$time_location[$i-1]));
					$countFirst++;
				}
			}
			$this->db->insert_batch('patrol', $data_patrol);

			$data_checkpoint = array(
				'id_checkpoint' => '',
				'id_collector'  => $data['collector'],
				'first_check'   => $first_check,
				'last_check'    => date('Y-m-d H:i:s',strtotime($data['date_last'] .' '. $data['hour_last'])),
				'id_route'      => substr($data['route'],6,1)
				);


			$this->db->insert('checkpoint', $data_checkpoint);
			$id_checkpoint = $this->db->insert_id();
			$count=0;
			$shift = 1;
			$data_patrol=array();
			for ($i=0; $i < sizeof($id_location); $i++) {
				if($data['date_shift'][$count]!=$data['date_first']){
					if(($count>1 && $data['date_shift'][$count]!=$data['date_shift'][$count-1])){
						$shift=1;
					}
					if ($id_location[$i]==$data['id_finish']) {
						$data_patrol[]=array(
						'id_checkpoint' => $id_checkpoint,
						'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count++]." ".$time_location[$i])),
						'id_location' => $id_location[$i],
						'shift' => $shift++,
						);

					}else{
						$data_patrol[]=array(
						'id_checkpoint' => $id_checkpoint,
						'time_location' => date('Y-m-d H:i:s',strtotime($data['date_shift'][$count]." ".$time_location[$i])),
						'id_location' => $id_location[$i],
						'shift' => $shift,
						);
					}
				}else{
					if($id_location[$i]==$data['id_finish']){
						$count++;
					}
				}
			}
			// var_dump($data_patrol);
			// echo "sini";
			$this->db->insert_batch('patrol', $data_patrol);
			return true;
		}
	}
	public function get_routeCheckpoint($id_route = FALSE, $time_location =FALSE)
	{
		if($id_route === FALSE)
		{
			$query = $this->db->get('checkpoint');
			return $query->result();
		}
		$this->db->select('id_route','time_location');
		$this->db->from('checkpoint c');
		$this->db->join('patrol p', 'p.id_checkpoint = c.id_checkpoint');
		return $query= $this->db->get()->result();
	}
	public function get_date_location($id_route = FALSE)
	{
		if ($id_route === FALSE){
		$this->db->select('convert(first_check, date) as first_check, convert(last_check, date) as last_check, id_checkpoint, id_route');
		$this->db->from('checkpoint');
		return $query = $this->db->get()->result();
		}

		$this->db->select('convert(first_check, date) as first_check, convert(last_check, date) as last_check, id_checkpoint, id_route');
		$this->db->from('checkpoint');
		$this->db->where('id_route',$id_route);
		return $query = $this->db->get()->result();
	}
	public function get_min_date($id_route = FALSE)
	{
		if($id_route === FALSE)
		{
			$query = $this->db->get('checkpoint');
			return $query->result();
		}   
		$this->db->select('min(convert(time_location, date)) as time_location');
		$this->db->from('patrol p');
		$this->db->join('checkpoint c', 'p.id_checkpoint = c.id_checkpoint');
		$this->db->where('id_route', $id_route);
		return $query= $this->db->get()->result();
	}

	public function get_search_date($id_route = FALSE)
	{
		if($id_route === FALSE)
		{
			$query = $this->db->get('checkpoint');
			return $query->result();
		}  
		$this->db->select('distinct date_format(convert(time_location, date), "%d-%m-%Y") as time_location');
		$this->db->from('patrol p');
		$this->db->join('checkpoint c', 'p.id_checkpoint = c.id_checkpoint');
		$this->db->where('id_route', $id_route);
	    return $query= $this->db->get()->result();
	}
	public function checkDate($id_route, $first_check)
	{		
		$this->db->select('id_checkpoint, convert(last_check, date) as last_check');
		$this->db->from('checkpoint');
		$this->db->where('convert(last_check, date) = ', nice_date($first_check, 'Y-m-d'));
		$this->db->where('id_route',$id_route);
		return $query = $this->db->get()->result();
	}

	public function getLastShift($id_route, $id_checkpoint, $first_check){
		$this->db->select('max(shift) as last_shift');
		$this->db->from('patrol p');
		$this->db->join('checkpoint c', 'p.id_checkpoint = c.id_checkpoint');
		$this->db->where('convert(time_location, date) = ', nice_date($first_check, 'Y-m-d'));
		$this->db->where('c.id_checkpoint', $id_checkpoint);
		$this->db->where('id_route',$id_route);
		return $query = $this->db->get()->result();

	}
}
?>