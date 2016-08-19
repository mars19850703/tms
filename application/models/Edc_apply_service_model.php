<?php

class Edc_apply_service_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateEdcApplyService($applyIdx, array $services)
    {
        $where = array(
            "edc_apply_idx" => intval($applyIdx)
        );

        $insertData = array();
        foreach ($services as $service) {
            $serviceArr = str_split($service, 3);
            $insertData[] = array(
                "edc_apply_idx" => intval($applyIdx),
                "supplier_idx"  => intval($serviceArr[0]),
                "product_idx"   => intval($serviceArr[1]),
                "action_idx"    => intval($serviceArr[2]),
                "option_idx"    => intval($serviceArr[3]),
            );
        }

        // log modify log
        $this->modifyLogForDelete($insertData, $where);

    	// delete old apply service
        $this->db->where($where);
        $this->db->delete($this->table);
        // insert new apply service
        $this->insertBatch($insertData);
    }

    public function getEdcApplyServiceByApplyIdx($applyIdx)
    {
        $where = array(
            "edc_apply_idx" => intval($applyIdx)
        );

        return $this->select(true, "array", $where);
    }
}
