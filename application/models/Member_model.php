<?php

class Member_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 產生會員編號
     * @return string [description]
     */
    public function createMemberId()
    {
        $memberId = randNumber();
        $this->db->select("idx, member_id")
                ->from($this->table)
                ->where('member_id', $memberId);
        $query = $this->db->get();
        if ($query->row_array()){           
            return $this->createMemberId();
        }else {            
            return $memberId;
        }
        
    }

    /**
     * 檢查會員帳號是否存在
     * @param  string $memberTaxId  [description]
     * @param  string $operatorName [description]
     * @return boolean               [description]
     */
    public function existEnterpriseMemberOperator($memberTaxId, $operatorName)
    {
        $this->db->select("Member.idx, Operator.idx as operator_idx, Operator.operator_name");
        $this->db->from($this->table);
        $this->db->join('Operator', 'Member.idx = Operator.member_idx', 'left');

        $this->db->where("Member.member_tax_id", $memberTaxId);

        $this->db->where('Operator.operator_name', $operatorName)
            ->where('Operator.operator_status != ', 9)
            ->where('Member.member_status != ', 9);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 檢查會員帳號是否存在
     * @param  string $memberTaxId  [description]
     * @param  string $operatorName [description]
     * @return boolean               [description]
     */
    public function existPersonalMemberOperator($memberIdentify, $operatorName)
    {
        $this->db->select("Member.idx, Operator.idx as operator_idx, Operator.operator_name");
        $this->db->from($this->table);
        $this->db->join('Operator', 'Member.idx = Operator.member_idx', 'left');

        $this->db->where("Member.member_tax_id IS NULL")
            ->where('Operator.operator_name', $operatorName)
            ->where('Operator.operator_status != ', 9)
            ->where('Member.member_status != ', 9);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existMemberByParam($where)
    {
        $this->db->select("Member.idx");
        $this->db->from($this->table);
        $this->db->where($where);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
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

    /**
     * 用條件查詢log資料
     * @param  string $memberTaxId 統一編號
     * @param  string   $operatorName 帳號
     * @param  string   $operatorEmail email
     * @return array         回傳Member跟Operator資料
     */
    public function getMemberOperator($memberTaxId, $operatorName, $operatorEmail = null)
    {
        $this->db->select("Member.idx, Member.member_name, Operator.idx as operator_idx, Operator.operator_name, Operator.operator_email");
        $this->db->from($this->table);
        $this->db->join('Operator', 'Member.idx = Operator.member_idx', 'left');

        if ($memberTaxId) {
            $this->db->where("Member.member_tax_id", $memberTaxId);
        } else {
            $this->db->where("Member.member_tax_id IS NULL")
                ->where("Operator.operator_email", $operatorEmail);
        }

        $this->db->where('Operator.operator_name', $operatorName)
            ->where('Operator.operator_status != ', 9)
            ->where('Member.member_status != ', 9);

        $query = $this->db->get();

        return $query->row_array();
    }

    /**
     * 會員登入
     * @param  string $memberTaxId      [description]
     * @param  string $operatorName     [description]
     * @param  string $operatorPassword [description]
     * @return [type]                   [description]
     */
    public function loginMemberOperator($memberTaxId, $operatorName, $operatorPassword, $memberStatus = 9, $operatorStatus = 1)
    {
        $columns = array('Member.member_name', 'Member.member_phone', 'Member.member_type', 'Operator.*');

        $this->db->select(join(',', $columns));
        $this->db->from($this->table);
        $this->db->join('Operator', 'Member.idx = Operator.member_idx', 'left');

        if ($memberTaxId) {
            $this->db->where("Member.member_tax_id", $memberTaxId);
        } else {
            $this->db->where('Member.member_tax_id IS NULL');
        }

        $this->db->where('Operator.operator_name', $operatorName)
            ->where('Operator.operator_password', $operatorPassword)
            ->where('Operator.operator_status = ', $operatorStatus)
            ->where('Member.member_status != ', $memberStatus);

        $query = $this->db->get();

        if ($operator = $query->row_array()) {
            unset($operator['operator_password']);
            return $operator;
        } else {
            return false;
        }
    }

    /**
     * 註冊暫時會員登入
     * @param  string $memberTaxId      [description]
     * @param  string $operatorName     [description]
     * @param  string $operatorPassword [description]
     * @return [type]                   [description]
     */
    public function loginTempMemberOperator($memberTaxId, $operatorName, $operatorPassword, $memberStatus = 8, $operatorStatus = 8)
    {
        $columns = array('Member.member_name', 'Member.member_company_name', 'Member.member_tel', 'Member.member_phone', 'Member.member_type', 'Operator.*');

        $this->db->select(join(',', $columns));
        $this->db->from($this->table);
        $this->db->join('Operator', 'Member.idx = Operator.member_idx', 'left');

        if ($memberTaxId) {
            $this->db->where("Member.member_tax_id", $memberTaxId);
        } else {
            $this->db->where('Member.member_tax_id IS NULL');
        }

        $this->db->where('Operator.operator_name', $operatorName)
            ->where('Operator.operator_password', $operatorPassword)
            ->where('Operator.operator_status', $operatorStatus)
            ->where('Member.member_status', $memberStatus);

        $query = $this->db->get();

        if ($operator = $query->row_array()) {
            unset($operator['operator_password']);
            return $operator;
        } else {
            return false;
        }
    }

    public function updateMember($member_idx, $data)
    {
        $where = array(
            "idx" => intval($member_idx)
        );

        return $this->update($data, $where);
    }
}
