<?php

class Edc_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEdcListsByFilters($filters)
    {
        $this->db->select("e.*, t.terminal_status, m.merchant_name, m.merchant_id");
        $this->db->from($this->table . " AS e");
        $this->db->join("Terminal AS t", "e.terminal_code = t.terminal_code", "left");
        $this->db->join("Merchant AS m", "e.merchant_idx = m.idx", "left");

        if (!empty($filters["terminal_id"]) && strlen($filters["terminal_id"]) === 4) {
            $this->db->where("e.terminal_code", $filters["terminal_code"]);
        }

        if (!empty($filters["merchant_id"])) {
            $this->db->where("m.merchant_id", $filters["merchant_id"]);
        }

        $this->db->where("e.member_idx", intval($filters["member_idx"]));
        $this->db->order_by("e.idx", "desc");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getEdcByIdx($idx)
    {
        $where = array(
            'idx' => intval($idx)
        );

        return $this->select(false, 'array', $where);
    }

    public function getEdcByMemberIdxAndTerminalCode($memberIdx, $terminalCode)
    {
        $where = array(
            'member_idx'    => intval($memberIdx),
            'terminal_code' => $terminalCode,
        );

        return $this->select(false, 'array', $where);
    }

    public function updateEdcSettingByEdcIdx($edcIdx, array $server, array $client)
    {
        $where = array(
            'idx' => intval($edcIdx),
        );

        $updateData = array(
            'edc_config'        => json_encode($server),
            'edc_client_config' => json_encode($client),
        );

        return $this->update($updateData, $where);
    }
}
