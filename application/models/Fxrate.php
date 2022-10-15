<?php
class Fxrate extends CI_Model 
{
	
	function saverecords($data)
	{
        return $this->db->insert('fxhistory',$data);
	}

    public function last_record () {
        $this->db->select_max('id');
        $res1 = $this->db->get('fxhistory');
        if ($res1->num_rows() > 0)
        {
            $res2 = $res1->result_array();
            $result = $res2[0]['id'];
    
            $this->db->select('*');
            $this->db->where('id', $result);
            $query = $this->db->get('fxhistory');
    
            if ($query->num_rows() > 0)
            {
                $row = $query->result_array();
                return $row[0];
            }
        }
        return NULL;
    }

    public function fx_data () {
        $result = $this->db->get('fxhistory');
        $result = $result->result_array();
        return $result[0];
    }
}