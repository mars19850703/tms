<?php

class Auth_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTransactionListsByFilters(array $filters)
    {
        $this->db->select("Auth.*, s.supplier_name, p.product_name, a.action_name, o.option_name");
        $this->db->from($this->table);
        $this->db->join("Supplier AS s", "Auth.supplier_idx = s.idx", "left");
        $this->db->join("Product AS p", "Auth.product_idx = p.idx", "left");
        $this->db->join("Action AS a", "Auth.action_idx = a.idx", "left");
        $this->db->join("Option AS o", "Auth.option_idx = o.idx", "left");

        // merchant id
        if (!empty($filters["merchant_id"])) {
            $this->db->where("Auth.merchant_id", $filters["merchant_id"]);
        }
        // terminal code
        if (!empty($filters["terminal_id"])) {
            $this->db->where("Auth.terminal_code", $filters["terminal_id"]);
        }

        // start & end
        if (!empty($filters["start"]) && !empty($filters["end"])) {
            $this->db->where("Auth.create_time >=", $filters["start"] . " 00:00:00");
            $this->db->where("Auth.create_time <=", $filters["end"] . " 23:59:59");
        }

        // limit & offset
        if (isset($filters["limit"]) && isset($filters["offset"]) && !empty($filters["limit"])) {
            $this->db->limit($filters["limit"], $filters["offset"]);
        } else if (isset($filters["limit"])) {
            $this->db->limit($filters["limit"]);
        }

        // type
        switch ($filters["type"]) {
            case 'auth':
                // $this->db->where("Auth.auth_status", 1);
                $this->db->where("Auth.cancel_status", 0);
                $this->db->where("Auth.request_status", 0);
                $this->db->where("Auth.refund_status", 0);
                break;
            case 'cancel':
                $this->db->where("Auth.auth_status", 1);
                $this->db->where("Auth.cancel_status", 1);
                $this->db->where("Auth.request_status", 0);
                $this->db->where("Auth.refund_status", 0);
                break;
            case 'request':
                $this->db->where("Auth.auth_status", 1);
                $this->db->where("Auth.cancel_status", 0);
                $this->db->group_start();
                $this->db->where("Auth.request_status", 1);
                $this->db->or_where("Auth.request_status", 2);
                $this->db->group_end();
                $this->db->where("Auth.refund_status", 0);
                break;
            case 'refund':
                $this->db->where("Auth.auth_status", 1);
                $this->db->where("Auth.cancel_status", 0);
                $this->db->where("Auth.request_status", 1);
                $this->db->group_start();
                $this->db->where("Auth.refund_status", 1);
                $this->db->or_where("Auth.refund_status", 2);
                $this->db->group_end();
                break;
            default:
                break;
        }

        $this->db->where("Auth.member_idx", intval($filters["member_idx"]));
        $this->db->order_by("Auth.idx", "desc");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getAuthByMemberIdxAndTransactionNo($memberIdx, $transactionNo)
    {
        $this->db->select("Auth.*, s.supplier_name, p.product_name, a.action_name, o.option_name");
        $this->db->from($this->table);
        $this->db->join("Supplier AS s", "Auth.supplier_idx = s.idx", "left");
        $this->db->join("Product AS p", "Auth.product_idx = p.idx", "left");
        $this->db->join("Action AS a", "Auth.action_idx = a.idx", "left");
        $this->db->join("Option AS o", "Auth.option_idx = o.idx", "left");
        $this->db->where("member_idx", intval($memberIdx));
        $this->db->where("transaction_no", $transactionNo);
        $query = $this->db->get();

        return $query->row_array();
    }
}
