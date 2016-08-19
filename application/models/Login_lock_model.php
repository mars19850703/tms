<?php

class Login_lock_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getByIp($ip, $now)
    {
        $this->db->select("*")
            ->from($this->table);

        $this->db->where('ip', $ip)
        			->where('lock_time >', $now)
        			->order_by('idx desc');    

        $query = $this->db->get();

        return $query->row_array();
    }
}
