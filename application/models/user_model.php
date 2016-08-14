<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	
	function cek($username, $password){
        $this->db->select('*');
		$this->db->where("username", $username);
        $this->db->where("password", $password);
        // $this->db->where("user_role_id", "1");        
        // $this->db->or_where("user_role_id", "2");        
		return $this->db->get("user");
    }
	
	function admin(){
		$this->db->select('username, password, full_name');
		$this->db->where("user_role_id", "1");        
		return $this->db->get("user");
	}
	
	function cek_admin($user){
        $this->db->select('username, password');
		$this->db->where("username", $user);
        $this->db->where("user_role_id", "1");
        return $this->db->get("user");
    }
	
	function update_admin($id, $info){
        $this->db->where("username", $id);
        $this->db->update("user", $info);
    }
	
	function cek_karyawan($user){
        $this->db->select('username, full_name, gender, birthdate, address, status,imei_number');
		$this->db->where("username", $user);
        $this->db->where("user_role_id", "2");
        return $this->db->get("user");
    }
	
	function updatekar($nis, $info){
        $this->db->where("username", $nis);
        $this->db->update("user", $info);
    }
	
	function get_karyawan_data($limit=10,$offset=0,$order_column='',$order_type='asc'){
        $this->db->select('username, full_name, gender, birthdate, address, status');
		$this->db->where("user_role_id", "2");   
		if(empty($order_column) || empty($order_type))
            $this->db->order_by($this->primary,'asc');
        else
            $this->db->order_by($order_column,$order_type);
        return $this->db->get("user",$limit,$offset);
    }
	
	function jumlah_karyawan(){
        return $this->db->count_all("user");
    }
	
	function cari_karyawan($cari){
        $this->db->select('*');
		$this->db->where("USER_ROLE_ID", "2");   
		$this->db->like("FULL_NAME",$cari);
        return $this->db->get("user");
    }
	
 	function login($username, $password)
	{		
		$this->db->select('username, imei_number');
		$this->db->from('user');
		$this->db->where('username', $username);
		$this->db->where('imei', $imei);
		$this->db->where('password', md5($password));
		
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
	
	function check_username($username)
	{		
		$this->db->select('username');
		$this->db->from('user');
		$this->db->where('username', $username);
		
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
 	
	function register($username, $password, $name, $gender, $birthdate, $imei)
	{
		
		$sgender;
		if($gender == 'M'){
			$sgender = '1';
		} else {
			$sgender = '2';
		}
		
		$nik = '10' . $sgender;
		$epoch = new DateTime(date('Y/m/d H:i:s'));	
		$data = array(
			//'username' => $epoch->format('U'),
			'username' => $username,
			'user_role_id' => 2,
			'user_active_id' => 1,
			'password' => md5($password),
			'full_name' => $name,
			'birthdate' => $birthdate,
			'gender' => $gender,
			'address' => 'Jl. Ganesha 10',
			'imei_number' => $imei,
			'Status' => 'aktif',
			'register_date' => date('Y/m/d H:i:s')
		);
		
		$result = $this->db->insert('user', $data);
		return $result;
	}
	
	function profile($username)
	{		
		$this->db->select('username, full_name, gender, birthdate, imei_number');
		$this->db->from('user');
		$this->db->where('username', $username);
		
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

	function get_by_id($condition)
    {
        $res = $this->db->get_where('user', $condition);
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
        return $this->db->get('user');
    }
}

?>
