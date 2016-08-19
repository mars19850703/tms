<?php

class MY_Model extends CI_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = str_replace("_model", "", get_class($this));
    }

    public function insert(array $data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertBatch(array $data)
    {
        if ($this->db->insert_batch($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {

    }

    public function update(array $data, $where = array())
    {
        if ($where) {
            $this->modifyLog($data, $where);
            if (is_array($where)) {
                $this->db->where($where);
            }
            return $this->db->update($this->table, $data);
        } else {
            return false;
        }
    }

    /**
     *  簡單的 select 整列
     *
     *  @param {boolean} $multi 單列還是多列
     *  @param {string} $type "array" || "object"
     *  @param {array} $where sql where 條件
     *  @param {array} $order 排序 array("column" => "desc")
     *  @param {int} $limit 一次取幾筆
     *  @param {int} $offset 從第幾個開始取
     *  @return {array || object}
     */
    public function select($multi = false, $type = "array", array $where, $order = null, $limit = null, $offset = null)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!is_null($order) && is_array($order) && !empty($order)) {
            foreach ($order as $column => $o) {
                $this->db->order_by($column, $o);
            }
        }

        if ((!is_null($limit) && is_numeric($limit)) && (!is_null($offset) && is_numeric($offset))) {
            $this->db->limit(intval($limit), intval($offset));
        } else if (!is_null($limit) && is_numeric($limit)) {
            $this->db->limit(intval($limit));
        }

        $query = $this->db->get();

        if ($type === "array") {
            if ($multi) {
                return $query->result_array();
            } else {
                return $query->row_array();
            }
        } else {
            if ($multi) {
                return $query->result();
            } else {
                return $query->row();
            }
        }
    }

    /**
     *    取得最後 query string
     *    @return string
     */
    public function getLastQuery()
    {
        return $this->db->last_query();
    }

    /**
     *  取得最近一次 query 的資料總筆數
     *
     *  @return int
     */
    public function getLastQueryCount()
    {
        $sql      = $this->getLastQuery();
        $tmp      = explode("LIMIT", $sql);
        $tmp2     = explode("FROM", $tmp[0]);
        $conutSql = "SELECT COUNT(*) AS total FROM " . $tmp2[1];
        $query    = $this->db->query($conutSql);
        $total    = $query->row_array();

        return $total["total"];
    }

    /**
     * 修改log記錄
     * @param  array $updateData 更新的資料
     * @param  array $where      條件
     * @return [type]             [description]
     */
    protected function modifyLog($updateData, $where)
    {
        if ($where) {
            $this->db->select("*")
                ->from($this->table)
                ->where($where);
            $query = $this->db->get();
            $datas = $query->result_array();
            if ($datas) {
                $diff_data = array();
                foreach ($datas as $data) {
                    array_push($diff_data, array_diff_assoc($updateData, $data));
                }

                $posts     = $this->input->post(null, true);
                $folder = $this->router->fetch_directory();
                $folder = (!empty($folder)? str_replace("/", "", $folder) : "");                    
                $insertLog = array(
                    'folder'              => $folder,
                    'controller'          => $this->router->fetch_class(),
                    'function'            => $this->router->fetch_method(),
                    'table'               => $this->table,
                    'posts_data'          => json_encode($posts),
                    'original_data'       => json_encode($datas),
                    'condition'           => json_encode($where),
                    'diff_data'           => json_encode($diff_data),
                    'modify_operator_idx' => $this->session->operator['idx'],
                    'modify_time'         => date("Y-m-d H:i:s"),
                    'ip'                  => $this->input->ip_address(),
                );
                $this->db->insert('Log_modify', $insertLog);
            }
        }
    }

    /**
     * 修改log記錄
     * @param  array $updateData 更新的資料
     * @param  array $where      條件
     * @return [type]             [description]
     */
    protected function modifyLogForDelete($updateData, $where)
    {
        if ($where) {
            $this->db->select("*")
                ->from($this->table)
                ->where($where);
            $query = $this->db->get();
            $datas = $query->result_array();
            if ($datas) {
                $posts     = $this->input->post(null, true);
                $folder = $this->router->fetch_directory();
                $folder = (!empty($folder) ? str_replace("/", "", $folder) : "");
                $insertLog = array(
                    'folder'              => $folder,
                    'controller'          => $this->router->fetch_class(),
                    'function'            => $this->router->fetch_method(),
                    'table'               => $this->table,
                    'posts_data'          => json_encode($posts),
                    'original_data'       => json_encode($datas),
                    'condition'           => json_encode($where),
                    'diff_data'           => json_encode($updateData),
                    'modify_operator_idx' => $this->session->operator['idx'],
                    'modify_time'         => date("Y-m-d H:i:s"),
                    'ip'                  => $this->input->ip_address(),
                );
                $this->db->insert('Log_modify', $insertLog);
            }
        }
    }
}
