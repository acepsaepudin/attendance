<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model
{
	
	function get_by_id($condition)
    {
        $res = $this->db->get_where('salary', $condition);
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
        return $this->db->get('salary');
    }

    function update($data, $condition=NULL)
    {
        if(isset($condition))
        {
            $this->db->where($condition);
        }
        
        return $this->db->set($data)
            ->update('salary');
    }

    function destroy($condition)
    {
        $this->db->delete('salary', $condition);
    }

     function save($data)
    {
        $this->db->insert('salary', $data);
        return $this->db->insert_id();
    }

}