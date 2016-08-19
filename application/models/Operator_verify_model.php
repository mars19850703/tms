<?php

class Operator_verify_model extends MY_Model
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


    /**
     * 取得最後一筆資料
     * @param  string $verifyType   驗證類型
     * @param  string $verifyTarget 驗證對象
     * @param  string $ltCreateTime 小於createTime unix_timestamp
     * @return array               資料庫row array
     */
    public function getLast($verifyType, $verifyTarget, $ltCreateTime = NULL)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("verify_type", $verifyType)
                    ->where('verify_target', $verifyTarget)
                    ->order_by('idx desc')
                    ->limit(1);
        if ($ltCreateTime){
            // $this->db->where('unix_timestamp(create_time) <=', $ltCreateTime);
            $this->db->where('create_time <=', $ltCreateTime);
        }
        $query = $this->db->get();

        return $query->row_array();
    }

}
