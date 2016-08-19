<?php

class Merchant_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 產生商店編號
     * @return string [description]
     */
    public function createMerchantId()
    {
        $merchantId = randNumber();
        $this->db->select("idx, merchant_id")
            ->from($this->table)
            ->where('merchant_id', $merchantId);
        $query = $this->db->get();
        if ($query->row_array()) {
            return $this->createMemberId();
        } else {
            return $merchantId;
        }

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

    public function getMerchantByMemberIdx($memberIdx)
    {
        $where = array(
            "member_idx" => intval($memberIdx),
        );

        return $this->select(true, "array", $where);
    }

    public function getMerchantListByFilters(array $filters)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        
        // merchant id
        if (isset($filters["merchant"]) && !empty($filters["merchant"])) {
            $this->db->where("merchant_id", $filters["merchant"]);
        }

        // keyword
        if (isset($filters["keyword"]) && !empty($filters["keyword"])) {
            // $this->db->group_start();
            // $this->db->like("order_email", $filters["keyword"]);
            // $this->db->or_like('order_phone', $filters["keyword"]);
            // $this->db->or_like('recipient_name', $filters["keyword"]);
            // $this->db->or_like('recipient_phone', $filters["keyword"]);
            // $this->db->group_end();
        }

        // member_idx
        if (isset($filters["member_idx"]) && !empty($filters["member_idx"])) {
            $this->db->where("member_idx", intval($filters["member_idx"]));
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

    public function getMerchantByMerchantId($merchantId)
    {
        $where = array(
            "merchant_id" => $merchantId,
        );

        return $this->select(false, "array", $where);
    }

    public function getMerchantByIdx($merchantIdx)
    {
        $where = array(
            "idx" => intval($merchantIdx),
        );

        return $this->select(false, "array", $where);
    }

    public function isMerchantIdExist($id)
    {
        $where = array(
            "merchant_id" => $id
        );

        $row = $this->select(false, "array", $where);
        if (is_null($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function insertMerchant(array $insertData)
    {
        $insertData["create_time"] = date("Y-m-d H:i:s");

        return $this->insert($insertData);
    }

    public function updateMerchant($merchantId, array $updateData)
    {
        $where = array(
            "merchant_id" => $merchantId
        );

        // modify
        $updateData["modify_time"] = date("Y-m-d H:i:s");

        return $this->update($updateData, $where);
    }
}
