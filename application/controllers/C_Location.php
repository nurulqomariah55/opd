<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Location extends CI_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }
  public function location()
  {
    $data['title'] = 'Location Report';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
    $data['allroute'] = $this->M_Route->get();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);  
    $this->load->view('location/V_Report', $data);
    $this->load->view('templates/footer', $data);
  }
  public function detail($id_route = FALSE, $time_location = FALSE)
  {
    $data['min_date'] = 00-00-0000;
      if(!$time_location)
      {  
         $time_location = $this->M_Checkpoint->get_min_date($id_route);
         $time_location = $time_location[0]->time_location;
         $data['min_date'] = date('d-m-Y',strtotime($time_location));
      }
    $data['title'] = "Route $id_route";
    $data['date_location'] = $this->M_Checkpoint->get_date_location($id_route);
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();      
      if (empty($data['date_location']))
      {
        $data['date_perday']=array();         
        $data['shift_perday'] = array();
        $data['route_location']= array(new stdClass);
        $data['route_location'][0]->id_route="None";
        $data['data_pershift'] = array();
        $data['min_max_timeshift'] = array();
      }
      else{
        $index=0;
          foreach ($data['date_location'] as $key => $dt)
          {
            if($time_location>=date('d-m-Y',strtotime($dt->first_check)) && $time_location<=date('d-m-Y',strtotime($dt->last_check)))
            {
              $index=$key;
            }
          }
          $data['count_perId']=$this->M_Location->count_patrol_perId($id_route);
          $id_checkpoint=$data['date_location'][$index]->id_checkpoint;
          $data['date_perday'] = $this->M_Location->get_patrol_perday($id_checkpoint);
          $time_location = date('Y-m-d',strtotime($time_location));          
          $data['shift_perday'] = $this->M_Location->get_shift_perday($id_checkpoint, $time_location);
          $data['route_location'] = $this->M_Route->get($id_route);
          $data['data_pershift'] = $this->M_Location->get_data_pershift($id_checkpoint,$time_location);
          $data['min_max_timeshift'] = $this->M_Location->get_min_max_timeshift($id_checkpoint,$time_location);
          $data['standard_time']=$this->M_Route->get($id_route);
          }
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('location/V_Location', $data);
          $this->load->view('templates/footer', $data);
   }
  public function add($id_location=FALSE)
  {
    $data['title'] = 'Setting Location';
    $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();

    $this->form_validation->set_rules('id_location', 'id location', 'required|numeric|is_unique[location.id_location]', 
      array(
          'is_unique'     => 'This %s already exists.'
      ));
    $this->form_validation->set_rules('location_name', 'location name', 'required');
      if($this->form_validation->run()===false){
         $data['display']= $this->M_Location->get();
         $this->load->view('templates/header', $data);
         $this->load->view('templates/sidebar', $data);  
         $this->load->view('checkpoint/V_checkpoint', $data);
         $this->load->view('templates/footer', $data);
      }
      else{
        if($this->M_Location->add()){
          $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong>successfully added </strong>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
          redirect(base_url('location/list'));
      }
    }
  }
  public function edit($id_location=FALSE)
  {
    if($this->M_Location->update($id_location)){
      $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been<strong> changed. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
      redirect(base_url('location/list'));
    } 
  }
  public function delete($id_location=FALSE)
  {
    if($this->M_Location->delete($id_location)){
          $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been <strong>deleted. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('location/list'));
    }
  }
  public function dataLoc()
  {
    echo json_encode($this->M_Location->get());
  }
  public function error()
  {
          $data['title'] = 'Page Not Found';
          $this->load->view('templates/header', $data);
          $this->load->view('error');
          $this->load->view('templates/footer');
   }
}
?>