<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Schedule extends CI_Controller 
{
  
  public function __construct()
  {
    parent::__construct();
  }

  public function add()
  {
    $data['title'] = 'Setting Schedule';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
    $data['route'] = $this->M_Route->get();
    $data['location'] = $this->M_Location->get();
    $this->form_validation->set_rules('id_route','route','required');
    $this->form_validation->set_rules('id_location[]','location', 'required');
    
     if($this->form_validation->run()==false)
     {  

        $data['schedule'] = $this->M_Schedule->getSetting();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);  
        $this->load->view('schedule/V_Setting', $data);
        $this->load->view('templates/footer', $data);
    }else{
      if($this->M_Schedule->add()){
           $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong> successfully added! </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
      }
      redirect(base_url('schedule/list'));
    }
  }
  public function dataSchedule($id_route=FALSE, $id_schedule=FALSE)
  {
    echo json_encode($this->M_Schedule->get($id_route, $id_schedule));
  }
  public function delete($id_route=FALSE, $id_schedule=FALSE)
  {
    if($this->M_Schedule->delete($id_route, $id_schedule)){
          $this->session->set_flashdata('message','<div class ="alert alert-success" role="alert"> The data has been <strong>deleted. </strong> </div>');
      redirect(base_url('schedule/list'));
    }
  }
  public function edit($id_route=FALSE, $id_schedule=FALSE)
  { 
    if($this->M_Schedule->update($id_route, $id_schedule)){
      $this->session->set_flashdata('message','<div class ="alert alert-success" role="alert">The data has been <strong>changed. </strong> </div>');
      redirect(base_url('schedule/list'));
    }
  }
}
?>