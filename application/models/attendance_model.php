<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
 	function get_date()
 	{
 		$this->db->select('attendance_id, attendance_in_date');
   		$this->db->from('attendance');
		$this->db->where("attendance_in_date =  '". date('Y-m-d') . "'");
		
   		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
 	}
	 
	function get_info_attendance()
 	{
 		$this->db->select('attendance_id, attendance_in_date, attendance_in_time, attendance_out_time');
   		$this->db->from('attendance');
		$this->db->where("attendance_in_date =  '". date('Y/m/d') . "'");
		
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
	 
	function insert_masuk($username, $latitude, $longitude)
	{
		
		date_default_timezone_set('Asia/Jakarta');
		$epoch = new DateTime(date('Y/m/d H:i:s'));	
		$data = array(
			'username' => $username,
			'office_id' => '1',
			'attendance_id' => $epoch->format('U'),
			'attendance_in_date' => date('Y/m/d'),
			'attendance_in_time' => date('H:i:s'),
			'attendance_out_date' => '',
			'attendance_out_time' => '',
			'latitude_in' => $latitude,
			'longitude_in' => $longitude			
		);
		
		$result = $this->db->insert('attendance', $data);
		return $result;
	}
	
	public function update_pulang($id, $latitude, $longitude)
	{
		date_default_timezone_set('Asia/Jakarta');
		$results = $this->db->
				update('attendance', array(
				'attendance_out_date' => date('Y/m/d'),
				'attendance_out_time' => date('H:i:s'),
				'latitude_out' => $latitude,
				'longitude_out' => $longitude	
				), array('attendance_id' => $id));
		
		return $results;
	}
	
	function get_current_attendance()
 	{
 		$this->db->select('attendance_in_date, attendance_in_time, attendance_out_time');
   		$this->db->from('attendance');
		$this->db->where("attendance_in_date =  '". date('Y-m-d') . "'");
		
   		$query = $this->db->get();

   		if($query -> num_rows() > 0)
   		{
     		return $query->row();
   		}
   		else
   		{
     		return null;
   		}
 	}
	 
	 function get_report_attendance()
 	{
 		$this->db->select('b.full_name, a.attendance_id, a.attendance_in_date, a.attendance_in_time, a.attendance_out_time');
   		$this->db->from('attendance a, user b');
		$this->db->where("a.attendance_in_date =  '". date('Y/m/d') . "'");
		
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

 	public function get_attendance_current_user($id)
 	{
 		$this->db->select('attendance_in_date, attendance_in_time, attendance_out_time');
		$this->db->where('attendance_id', $id);
		$this->db->where('attendance_in_date',date('Y-m-d'));
   		$this->db->from('attendance');

   		$query = $this->db->get();

   		if($query -> num_rows() == 1)
   		{
     		// return $query->row();
     		return TRUE;
   		}
   		else
   		{
     		return FALSE;
   		}
 	}

 	function get_by_id($condition)
    {
        $res = $this->db->get_where('attendance', $condition);
        if ($res->num_rows() > 0) {
            $result = $res->row();
        } else {
            $result = '';
        }
        return $result;
    }

    function get_all($condition=null)
    {
        if (isset($condition)) {
            $this->db->where($condition);
        }
        return $this->db->get('attendance');
    }
	 		
}

?>