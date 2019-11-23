<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Route extends CI_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }
  
  	public function dataTime(){
      $standard_time=$this->M_Route->get();    
      echo json_encode($standard_time, JSON_PRETTY_PRINT);
 	 }
    public function add()
    {
      $data['title'] = 'Setting Route';
      $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
      $this->form_validation->set_rules('id_route', 'id route', 'required|max_length[1]|is_unique[route.id_route]', 
        array(
        'is_unique'     => 'This %s already exists.'
      ));
      $this->form_validation->set_rules('route_name', 'route name', 'required');
      $this->form_validation->set_rules('standard_time', 'standard  time', 'required|numeric');
      if($this->form_validation->run()===false)
      {
            $data['show']= $this->M_Route->get();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);  
            $this->load->view('route/V_Route', $data);
            $this->load->view('templates/footer', $data);
      }else{    
        if($this->M_Route->add()){
           $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong>successfully added </strong>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('route/list'));
          }
        }
      }
    public function edit($id_route=FALSE)
    {
     if($this->M_Route->update($id_route)){
        $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been <strong>changed. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('route/list'));
     }
    }
    public function delete($id_route=FALSE)
    {
      if($this->M_Route->delete($id_route)){
          $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been<strong> deleted. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('route/list'));
      }
    }
    public function search()
    {
       echo json_encode($this->M_Route->get());
    }
}
?>