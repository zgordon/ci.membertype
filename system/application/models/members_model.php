<?
class Members_model extends Model {

    function Members_model()
    {
        parent::Model();
    }
	
	function pa($array)
	{
		echo '<pre>';
		var_dump($array);
		echo '</pre>';
	}
	function get_members() 
	{
		$query = $this->db->get('exp_members');
		foreach ($query->result() as $row)
		{
			$member_info = $this->get_member_info_by_id($row->member_id);
			$membertypes_ids = $this->get_membertypes_by_member_id($row->member_id);
			$member_info['membertype_checkbox'] = $this->get_member_membertype_checkboxes($membertypes_ids);
/*
			foreach($membertypes_ids as $membertypes_id)
			{
				$member_info['membertypes'][] = $this->get_membertype_info_by_id($membertypes_id);
			}					
*/
		    $members[] = $member_info;
		}
		return $members;
	}

	function get_member_info_by_id($member_id)
	{		
		$this->db->select('member_id, group_id, username, screen_name, email');
		$this->db->where('member_id', $member_id); 
		$query = $this->db->get('exp_members');
		foreach ($query->result() as $row)
		{
		    $member['member_id'] = $row->member_id;
			$member['group_id'] = $row->group_id;
			$member['username'] = $row->username;				
		    $member['screen_name'] = $row->screen_name;
		    $member['email'] = $row->email;		
		}
		return $member;		
	}

	function get_membertypes() 
	{
		$query = $this->db->get('exp_membertypes');
		foreach ($query->result() as $row)
		{
			$membertype['membertype_id'] = $row->membertype_id;    
			$membertype['membertype_name'] = $row->membertype_name;
			$membertypes[] = $membertype;
		}
		return $membertypes;
	}

	function get_membertype_ids() 
	{
		$membertype_ids;
		$this->db->select('membertype_id');
		$query = $this->db->get('exp_membertypes');
		foreach ($query->result() as $row)
		{
			$membertype_ids[] = $row->membertype_id;    
		}
		return $membertype_ids;
	}	

	function get_membertypes_as_checkboxes() 
	{
		$checkboxes = '<ul>';
		$membertypes = $this->get_membertypes();
		//$this->pa($membertypes);
		foreach($membertypes as $membertype)
		{
			$checkboxes .= '<li>';
			$checkboxes .= '<input type="checkbox" ';
			$checkboxes .= 'id="membertype_' . $membertype['membertype_id'] . ' ';
			$checkboxes .= 'name="' . $membertype['membertype_id'] . '" ';
			$checkboxes .= '/>';
			$checkboxes .= '<label for="membertype_' . $membertype['membertype_id'] . '">';
			$checkboxes .= $membertype['membertype_name'];
			$checkboxes .= '</label>';
			$checkboxes .= '</li>';
		}
		$checkboxes .= '</ul>';
		
		return $checkboxes;
	}

	function get_member_membertype_checkboxes($membertype_ids) 
	{
		$checkboxes = '<ul>';
		$checkboxes .= "\n";		
		$membertypes = $this->get_membertypes();
		foreach($membertypes as $membertype)
		{
			$checkboxes .= '<li>';
			$checkboxes .= "\n";
			$checkboxes .= '<input type="checkbox" ';
			$checkboxes .= 'id="membertype_id_' . $membertype['membertype_id'] . '" ';			
			$checkboxes .= 'name="membertypes[]" ';
			$checkboxes .= 'value="' . $membertype['membertype_id'] . '" ';			
			if($membertype_ids != null)
			{
				if(in_array($membertype['membertype_id'], $membertype_ids)) $checkboxes .= ' checked ';				
			}			
			$checkboxes .= '/>';
			$checkboxes .= '<label for="membertype_' . $membertype['membertype_id'] . '">';
			$checkboxes .= $membertype['membertype_name'];
			$checkboxes .= '</label>';			
			$checkboxes .= '</li>';
			$checkboxes .= "\n";			
		}
		$checkboxes .= '</ul>';
		$checkboxes .= "\n";		
		return $checkboxes;
	}				

	function get_membertype_info_by_id($membertype_id) 
	{		
		$this->db->where('membertype_id', $membertype_id); 		
		$query = $this->db->get('exp_membertypes');		
		foreach ($query->result() as $row)
		{
		    $membertype['membertype_id'] = $membertype_id;
			$membertype['membertype_name'] = $row->membertype_name;
		}
		return $membertype;
	}

	function get_membertypes_by_member_id($member_id) 
	{		
		$membertype_ids = null;
		$this->db->where('member_id', $member_id); 		
		$this->db->select('membertype_id');
		$query = $this->db->get('exp_member_membertypes');		
		foreach ($query->result() as $row)
		{
		    $membertype_ids[] = $row->membertype_id;
		}
		return $membertype_ids;
	}					
	
	function add_membertypes($membertype_name)
	{
		$this->db->set('membertype_name', $membertype_name);
		$this->db->insert('exp_membertypes');				
	}
	
	function add_member_membertype($member_id, $membertype_id)
	{
		$this->db->set('member_id', $member_id);
		$this->db->set('membertype_id', $membertype_id);
		$this->db->insert('exp_member_membertypes');
	}	

	function delete_member_membertype($member_id, $membertype_id)
	{
		$this->db->where('member_id', $member_id);
		$this->db->where('membertype_id', $membertype_id);
		$this->db->delete('exp_member_membertypes');		
	}

	function delete_member_membertypes($member_id)
	{
		$this->db->where('member_id', $member_id);
		$this->db->delete('exp_member_membertypes');		
	}

	function delete_membertypes($membertype_ids)
	{
		if(is_array($membertype_ids))
		{
			foreach($membertype_ids as $membertype_id)
			{
				$this->db->where('membertype_id', $membertype_id);
				$this->db->delete('exp_member_membertypes');			
				$this->db->where('membertype_id', $membertype_id);
				$this->db->delete('exp_membertypes');			
			}			
		}
		else
		{
			$this->db->where('membertype_id', $membertype_ids);
			$this->db->delete('exp_member_membertypes');			
			$this->db->where('membertype_id', $membertype_ids);
			$this->db->delete('exp_membertypes');						
		}
	}			
	
	function check_member_membertype($member_id, $membertype_id)
	{
		$this->db->where('member_id', $member_id);
		$this->db->where('membertype_id', $membertype_id);
		$query = $this->db->get('exp_member_membertypes');		
		if($query->num_rows() > 0) return true;
		else return false;
	}	
		
	function update_member_member_types($member_id, $membertypes)
	{				
		if($membertypes != null)
		{
			foreach($membertypes as $membertype_id)
			{		
				$membertype_exists = $this->check_member_membertype($member_id, $membertype_id);				
				if($membertype_exists == false) $this->add_member_membertype($member_id, $membertype_id); 
			}
			$current_membertypes = $this->get_membertype_ids();
			foreach($current_membertypes as $current_membertype_id)							
			{
				if(!in_array($current_membertype_id, $membertypes))
				{
					$this->delete_member_membertype($member_id, $current_membertype_id);
				}
			}			
		}
		else
		{
			$this->delete_member_membertypes($member_id);
		}
		$current_membertypes = 	$this->get_membertypes_by_member_id($member_id);		
	}
}