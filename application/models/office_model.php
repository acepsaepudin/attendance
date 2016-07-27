<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Office_model extends CI_Model
{
 	function get_details()
 	{
 		$this->db->select('office_id, office_name, office_address, office_latitude, office_longitude');
   		$this->db->from('office');
		
   		$query = $this->db->get();

   		if($query -> num_rows() == 1)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
 	}
	
}

?>