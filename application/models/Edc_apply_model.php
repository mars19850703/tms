<?php

class Edc_apply_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getApplyListByFilters(array $filters)
    {
    	$this->db->select("*");
    	$this->db->from($this->table);

    	// apply status
    	if (isset($filters["status"]) && is_numeric($filters["status"])) {
    		$this->db->where("apply_status", intval($filters["status"]));
    	}

        // merchant id
        if (isset($filters["merchant_id"]) && is_numeric($filters["merchant_id"])) {
            $this->db->where("merchant_id", $filters["merchant_id"]);
        }

        // member_idx
        if (isset($filters["member_idx"]) && is_numeric($filters["member_idx"])) {
            $this->db->where("member_idx", $filters["member_idx"]);
        }

        // limit & offset
        if (isset($filters["limit"]) && isset($filters["offset"]) && !empty($filters["limit"])) {
            $this->db->limit($filters["limit"], $filters["offset"]);
        } else if (isset($filters["limit"])) {
            $this->db->limit($filters["limit"]);
        }

        $this->db->order_by("idx", "desc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getApplyByApplyId($applyId)
    {
        $where = array(
            "apply_id" => $applyId
        );

        return $this->select(false, "array", $where);
    }

    public function isApplyIdExist($id)
    {
        $where = array(
            "apply_id" => $id
        );

        $row = $this->select(false, "array", $where);
        if (is_null($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function insertEdcApply(array $insertData)
    {
        $insertData["create_time"] = date("Y-m-d H:i:s");

        return $this->insert($insertData);
    }

    public function updateEdcApply($applyId, array $updateData)
    {
        $where = array(
            "apply_id" => $applyId
        );

        // modify
        $updateData["modify_time"] = date("Y-m-d H:i:s");

        return $this->update($updateData, $where);
    }
}
