<?php

class Edc_app_mapping_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAppDetailByEdcSetIdx($edcSetIdx)
    {
    	$this->db->select('a.*')
    			 ->from($this->table . ' AS eam')
    			 ->join('App AS a', 'eam.app_idx = a.idx', 'left')
    			 ->where('eam.edc_set_idx', intval($edcSetIdx));
    	$query = $this->db->get();

    	return $query->result_array();
    }
}
