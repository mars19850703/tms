<?php

class Cancel_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCancelByAuthIdx($authIdx)
    {
        $where = array(
            "auth_idx"      => intval($authIdx),
            // "cancel_status" => 1,
        );

        return $this->select(true, "array", $where);
    }
}
