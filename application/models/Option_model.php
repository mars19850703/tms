<?php

class Option_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOption()
    {
        $where = array();

        return $this->select(true, "array", $where);
    }

    public function getOptionByService($supplierIdx, $productIdx, $actionIdx, $optionCode)
    {
        $where = array(
            'supplier_idx' => intval($supplierIdx),
            'product_idx'  => intval($productIdx),
            'action_idx'   => intval($actionIdx),
            'option_code'  => $optionCode,
        );

        return $this->select(false, 'array', $where);
    }
}
