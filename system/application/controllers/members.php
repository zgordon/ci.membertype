<?php

class Members extends Controller {

	function Members()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$data['members'] = $this->Members_model->get_members();		
		$data['membertypes'] = $this->Members_model->get_membertypes();				
		$this->load->view('members_view', $data);
	}
	
	function add_membertype()
	{
		$membertype_name = $this->input->post('membertype_name', TRUE);
		if($membertype_name != '') $this->Members_model->add_membertypes($membertype_name);		
		redirect('/members/', 'refresh');
	}
	
	function update_member_membertypes()
	{
		$member_id = $this->input->post('member_id', TRUE);
		$membertypes = $this->input->post('membertypes', TRUE);		
		$this->Members_model->update_member_member_types($member_id, $membertypes);
		redirect('/members/', 'refresh');
	}
	
	function delete_membertype()
	{
		$membertype_id = $this->input->post('membertype_id', TRUE);
		$this->Members_model->delete_membertypes($membertype_id);
		redirect('/members/', 'refresh');
	}	
}