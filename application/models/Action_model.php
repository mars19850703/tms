<?php

class Action_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAction()
    {
        $where = array();

        return $this->select(true, "array", $where);
    }
}
