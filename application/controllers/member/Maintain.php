<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maintain extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("member_model");
        $this->lang->load('language', str_replace('/', '', $this->languageFolder));

        $this->data["title"]     = Constant::MemberMaintainTitle;
        $this->response["Title"] = Constant::MemberMaintainTitle;
    }

    public function index()
    {
        $where = array(
            "idx" => $this->data["operator"]["member_idx"],
        );
        $this->data["member"] = $this->member_model->getByParam(false, $where);

        // MY_Controller::dumpData($this->data);

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
            "/apps/js/tms/aj-address",
            "/apps/js/tms/jquery.check_data",
        );

        if ($this->data["operator"]["member_type"] == "1") {
            $js[]                        = "/apps/js/tms/member/personal";
            $this->data["maintain_view"] = $this->load->view($this->languageFolder . "member/maintain/personal_view", $this->data, true);
        } else {
            $js[]                        = "/apps/js/tms/member/company";
            $this->data["maintain_view"] = $this->load->view($this->languageFolder . "member/maintain/company_view", $this->data, true);
        }

        $this->setJs($js);

        $this->render('member/maintain_view', $this->data);
    }

    public function updateMemberInfo()
    {
        if ($this->isAjax()) {
            $this->load->library("check_data/valid");
            $fields = array(
                'member_email',
                'member_tel',
                'member_address',
                'member_en_name',
                'id_card_place',
                'id_card_date'
            );

            $this->data["post"] = $this->input->post($fields, true);

            if (!is_null($this->data["post"]["member_email"]) && !empty($this->data["post"]["member_email"])) {
                $this->valid->setRules("member_email", "required|email");
                $this->valid->setMessage("member_email", Constant::EmailFormateError);
            } else {
                unset($this->data["post"]["member_email"]);
            }

            if (!is_null($this->data["post"]["member_tel"]) && !empty($this->data["post"]["member_tel"])) {
                $this->valid->setRules("member_tel", "required|minLength[9]|maxLength[10]|numeric");
                $this->valid->setMessage("member_tel", Constant::TelFormateError);
            }

            if (!is_null($this->data["post"]["member_address"]) && !empty($this->data["post"]["member_address"])) {
                $this->valid->setRules("member_address", "required|minLength[8]");
                $this->valid->setMessage("member_address", Constant::AddressLengthNotEnough);
            }

            // member_en_name
            $this->valid->setRules('member_en_name', "required|minLength[1]");
            $this->valid->setMessage('member_en_name', Constant::MemberEnNameFormatError);
            // id_card_place
            $this->valid->setRules('id_card_place', "required|minLength[3]|maxLength[3]");
            $this->valid->setMessage('id_card_place', Constant::MemberIdCardPlaceFormatError);
            // id_card_date
            $this->valid->setRules('id_card_date', array(
                'required',
                'minLength[10]',
                'maxLength[10]',
                array(
                    'date_more_then_today',
                    function ($value) {
                        // 判斷身分證發換證日期是否大於今天
                        if (strtotime($value) < time()) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                )
            ));
            $this->valid->setMessage('id_card_date', Constant::MemberIdCardDateFormatError);
            $this->valid->setMessage('date_more_then_today', Constant::MemberIdCardDateMoreThenToday);

            if (!$this->valid->run($this->data["post"])) {
                $this->response["Message"] = $this->valid->getErrors();
            } else {
                $this->data["post"]["modify_time"]         = date("Y-m-d H:i:s");
                $this->data["post"]["modify_operator_idx"] = $this->data["operator"]["idx"];
                if ($this->member_model->updateMember($this->data["operator"]["member_idx"], $this->data["post"])) {
                    $this->response["Status"]  = true;
                    $this->response["Message"] = Constant::UpdateDataSuccess;
                } else {
                    $this->response["Message"] = Constant::DatabaseError;
                }
            }
        }

        $this->tms_output->output($this->response);
    }
}
