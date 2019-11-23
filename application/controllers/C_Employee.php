<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Employee extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function add()
	{
		$data['title'] = 'Setting Employee';
		$data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row_array();
		$this->form_validation->set_rules('no_badge', 'no badge', 'required|numeric|is_unique[employee.no_badge]', 
      array(
        'is_unique'     => 'This %s already exists.'
    ));
    $this->form_validation->set_rules('name', 'name', 'required');
      	if($this->form_validation->run()===false)
      	{
            $data['show']= $this->M_Employee->get();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);  
            $this->load->view('employee/V_Employee', $data);
            $this->load->view('templates/footer', $data);
      	}else{    
        	if($this->M_Employee->add()){
           		$this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has <strong>successfully added </strong>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           		redirect(base_url('employee/list'));
       		}	
       	}
    }
    public function edit($no_badge=FALSE)
    {
      if($this->M_Employee->update($no_badge)){
        $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been <strong>changed. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('employee/list'));
      }
    }
    public function delete($no_badge=FALSE)
    {
      if($this->M_Employee->delete($no_badge)){
          $this->session->set_flashdata('message','<div class ="alert alert-success alert-dismissible fade show" role="alert">The data has been<strong> deleted. </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </div>');
           redirect(base_url('employee/list'));
      }
    }
}
?>