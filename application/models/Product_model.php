<?php

class Product_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProduct()
    {
        $where = array(
            "product_status" => 1,
        );

        return $this->select(true, "array", $where);
    }
}
