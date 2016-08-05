<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Late_model extends CI_Model
{
	
	function get_by_id($condition)
    {
        $res = $this->db->get_where('late', $condition);
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
        return $this->db->get('late');
    }

    function update($data, $condition=NULL)
    {
        if(isset($condition))
        {
            $this->db->where($condition);
        }
        
        return $this->db->set($data)
            ->update('late');
    }

    function destroy($condition)
    {
        $this->db->delete('late', $condition);
    }

     function save($data)
    {
        $this->db->insert('late', $data);
        return $this->db->insert_id();
    }

}