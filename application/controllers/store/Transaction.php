<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth_model");
        $this->load->model("merchant_model");

        $this->limit             = 10;
        $this->data["title"]     = Constant::StoreTransactionTitle;
        $this->response["Title"] = Constant::StoreTransactionTitle;
    }

    public function index()
    {
        $this->lists();
    }

    public function lists()
    {
        $this->data["filters"] = $this->input->get(array("start", "end", "merchant_id", "terminal_id"), true);

        // get merchant list
        $this->data["merchants"] = $this->merchant_model->getMerchantByMemberIdx($this->data["operator"]["member_idx"]);

        // set css
        $css = array(
            "source" => array(
                "/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min",
            ),
        );
        $this->setCss($css);
        // set js
        $js = array(
            "/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min",
            "/global/plugins/jquery-bootpag/jquery.bootpag.min",
            "/apps/js/tms/store/transaction_list",
        );
        $this->setJs($js);

        $this->render('store/transaction_list_view', $this->data);
    }

    public function detail($transactionNo)
    {
        $this->data["auth"] = $this->auth_model->getAuthByMemberIdxAndTransactionNo($this->data["operator"]["member_idx"], $transactionNo);

        if (!is_null($this->data["auth"])) {

            // MY_Controller::dumpData($this->data);

            $this->render("store/transaction_detail_view", $this->data);
        } else {
            redirect("/store/transaction/lists");
        }
    }

    public function getTransactions()
    {
        if ($this->isAjax()) {
            // filters
            $this->data["filters"] = $this->input->post(array("terminal_id", "merchant_id", "start", "end", "page"), true);

            // page
            if (empty($this->data["filters"]["page"])) {
                $this->data["filters"]["page"] = 1;
            }
            $this->data["filters"]["limit"]  = $this->limit;
            $this->data["filters"]["offset"] = ($this->data["filters"]["page"] - 1) * $this->limit;

            // filters auth status
            $this->data["filters"]["status"] = 1;

            // filters member_idx
            $this->data["filters"]["member_idx"] = $this->data["operator"]["member_idx"];

            // transactions list
            $this->data["auths"]      = $this->auth_model->getTransactionListsByFilters($this->data["filters"]);

            // MY_Controller::dumpData($this->data["auths"], $this->db->last_query());

            $this->data["totalPage"] = ceil($this->auth_model->getLastQueryCount() / $this->data["filters"]["limit"]);

            // load view
            $this->response["transaction"] = $this->load->view($this->languageFolder . "store/transaction_list_table_view", $this->data, true);

            $this->response["Status"] = true;
        }

        $this->tms_output->output($this->response);
    }
}
