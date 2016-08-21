<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Workingdays_model extends CI_Model
{
	
	function get_by_id($condition)
    {
        $res = $this->db->get_where('working_days', $condition);
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
        return $this->db->get('working_days');
    }

    function update($data, $condition=NULL)
    {
        if(isset($condition))
        {
            $this->db->where($condition);
        }
        
        return $this->db->set($data)
            ->update('working_days');
    }

    function destroy($condition)
    {
        $this->db->delete('working_days', $condition);
    }

     function save($data)
    {
        $this->db->insert('working_days', $data);
        return $this->db->insert_id();
    }

}