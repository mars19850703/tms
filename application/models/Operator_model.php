<?php

class Operator_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 用條件查詢log資料
     * @param  boolean $multi 資料是多筆還是單筆
     * @param  array   $where 要查詢的條件
     * @return array         回傳log資料
     */
    public function getByParam($multi = false, array $where)
    {
        return $this->select(false, "array", $where);
    }    

    public function getOperatorListByFilters(array $filters)
    {
        $where = array(
            "operator_type" => 0
        );
        $where = array_merge($where, $filters);

        $order = array(
            "idx" => "desc"
        );

        return $this->select(true, "array", $where, $order);
    }

    public function insertOperator(array $insertData)
    {
        $insertData["operator_password"] = md5($insertData["operator_password"]);
        $insertData["create_time"] = date("Y-m-d H:i:s");

        return $this->insert($insertData);
    }

    public function updateOperator($operatorIdx, $updateData)
    {
        $where = array(
            "idx" => intval($operatorIdx)
        );

        // modify
        $updateData["modify_time"] = date("Y-m-d H:i:s");

        return $this->update($updateData, $where);
    }

    public function isOperatorNameExistForPersonal($name)
    {
        $this->db->select("*");
        $this->db->from($this->table . " as o");
        $this->db->join("Member as m", "o.member_idx = m.idx", "left");
        $this->db->where("m.member_type", 1);
        $this->db->where("o.operator_name", $name);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isOperatorNameExistForCompany($member_idx, $name)
    {
        $this->db->select("*");
        $this->db->from($this->table . " as o");
        $this->db->join("Member as m", "o.member_idx = m.idx", "left");
        $this->db->where("m.member_type", 2);
        $this->db->where("m.idx", intval($member_idx));
        $this->db->where("o.operator_name", $name);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isOperatorQuantityOver($member_idx)
    {
        $where = array(
            "member_idx" => intval($member_idx)
        );

        $operator = $this->select(true, "array", $where);

        if (count($operator) >= 11) {
            return true;
        } else {
            return false;
        }
    }

    public function getOperatorByIdx($idx)
    {
        $where = array(
            "idx" => intval($idx),
        );

        return $this->select(false, "array", $where);
    }
}
