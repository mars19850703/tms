<?php

class Supplier_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSupplier()
    {
        $where = array(
            "supplier_status" => 1,
        );

        return $this->select(true, "array", $where);
    }
}
