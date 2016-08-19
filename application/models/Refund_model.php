<?php

class Refund_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRefundByAuthIdx($authIdx)
    {
        $where = array(
            "auth_idx"      => intval($authIdx),
            // "refund_status" => 1,
        );

        return $this->select(true, "array", $where);
    }
}
