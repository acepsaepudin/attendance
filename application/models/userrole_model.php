<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Userrole_model extends CI_Model
{
	
	function get_by_id($condition)
    {
        $res = $this->db->get_where('user_role', $condition);
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
        return $this->db->get('user_role');
    }

    function update($data, $condition=NULL)
    {
        if(isset($condition))
        {
            $this->db->where($condition);
        }
        
        return $this->db->set($data)
            ->update('user_role');
    }

    function destroy($condition)
    {
        $this->db->delete('user_role', $condition);
    }

     function save($data)
    {
        $this->db->insert('user_role', $data);
        return $this->db->insert_id();
    }

}