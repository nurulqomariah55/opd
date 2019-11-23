<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Security extends CI_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }
  public function add()
  {
  	$data['title'] = 'Checkpoint Schedule';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
    $data['route'] = $this->M_Route->get();
    $data['employee'] = $this->M_Employee->get();
    $this->form_validation->set_rules('route','route','required');
    $this->form_validation->set_rules('employee[]','security name','required');

    if($this->form_validation->run()== false)
    {
      $data['var_route']= array(new stdClass);
      $data['var_route'][0]->id_route="-";
      $data['schedule'] = array();
      $data['security']=array();
    }else{
      $data['var_route'] = $this->M_Schedule->varSchedule($this->input->post('route'));
      if($this->input->post('route')=="B")
      {
        $data['schedule']=array();
        $data['var_route']= array(new stdClass);
        $data['var_route'][0]->id_route="-";
        $data['security']=array();
      }else{
        $data['schedule']=array();
        $data['security']=array();
        if(!empty($data['var_route'])){
          // var_dump($data['var_route']);
          $_POST["id_schedule"] = rand(1,$data['var_route'][0]->jumlah); 
        }else{          
          $data['var_route']= array(new stdClass);
          $data['var_route'][0]->id_route="-";
        }
  		if($this->M_Security->add()){
        $data['schedule'] = $this->M_Schedule->getSchedule($_POST["id_schedule"],$this->input->post('route'));
        $data['security'] = $this->input->post('employee');
           $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong>successfully added! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
          }
        }
      } 
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);  
      $this->load->view('schedule/V_Schedule', $data);
      $this->load->view('templates/footer', $data);
  	}
  public function list()
  {
    $data['title'] = 'Security Schedule';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
    $data['list'] = $this->M_Security->list();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);  
    $this->load->view('security/V_Security', $data);
    $this->load->view('templates/footer', $data);
  }
  public function detail($patrol_date=FALSE){
    $detail=$this->M_Security->detail(str_replace("_", " ", $patrol_date));
    echo json_encode($detail, JSON_PRETTY_PRINT);
  }
}
?>