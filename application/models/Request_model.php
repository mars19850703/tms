<?php

class Request_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRequestByAuthIdx($authIdx)
    {
        $where = array(
            "auth_idx"       => intval($authIdx),
            // "request_status" => 1,
        );

        return $this->select(true, "array", $where);
    }
}
