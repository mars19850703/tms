<?php

class Edc_update_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertEdcConfigUpdate($operatorIdx, array $terminal)
    {
        $this->db->select('*')
            ->from('Edc')
            ->where('idx', intval($terminal['edc_idx']));
        $query = $this->db->get();
        $edc   = $query->row_array();

        $this->db->flush_cache();
        $insertData = array(
            'edc_idx'            => $edc['idx'],
            'edc_set_idx'        => intval($terminal['edc_set_idx']),
            'terminal_idx'       => intval($terminal['idx']),
            'update_type'        => 2,
            'update_priorty'     => 1,
            'device_idx'         => intval($edc['device_idx']),
            'batch_time'         => time(),
            'create_time'        => date('Y-m-d H:i:s'),
            'create_manager_idx' => intval($operatorIdx),
        );

        return $this->insert($insertData);
    }
}
