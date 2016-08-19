<?php

class Terminal_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTerminalListsByFilters($filters)
    {
        $this->db->select("t.*, m.merchant_name, m.merchant_id");
        $this->db->from($this->table . " AS t");
        $this->db->join("Merchant AS m", "t.merchant_idx = m.idx", "left");

        if (!empty($filters["terminal_id"]) && strlen($filters["terminal_id"]) === 4) {
            $this->db->where("t.terminal_code", $filters["terminal_id"]);
        }

        if (!empty($filters["merchant_id"])) {
            $this->db->where("m.merchant_id", $filters["merchant_id"]);
        }

        $this->db->where("t.member_idx", intval($filters["member_idx"]));
        $this->db->order_by("t.idx", "desc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTerminalByIdx($idx)
    {
        $where = array(
            'idx' => intval($idx)
        );

        return $this->select(false, 'array', $where);
    }

    public function getTerminalByMemberIdxAndMerchantIdxAndTerminalCode($memberIdx, $merchantIdx, $terminalCode)
    {
        $where = array(
            'member_idx'    => intval($memberIdx),
            'merchant_idx'  => intval($merchantIdx),
            'terminal_code' => $terminalCode,
        );

        return $this->select(false, 'array', $where);
    }

    public function updateTerminalSettingByTerminalIdx($terminalIdx, array $server, array $client)
    {
        
        $where = array(
            'idx' => intval($terminalIdx),
        );

        $updateData = array(
            'edc_config'        => json_encode($server),
            'edc_client_config' => json_encode($client),
        );

        return $this->update($updateData, $where);
    }
}
