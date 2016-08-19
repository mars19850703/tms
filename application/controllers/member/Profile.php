<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("member_model");
        $this->load->model("operator_model");
        // load permission model
        $this->load->model("permission_model");
        // load permission array
        $this->config->load('global_permission', true);
        $this->data["permissionMapping"] = $this->config->item("tms", "global_permission");

        $this->limit             = 10;
        $this->data["title"]     = Constant::MemberOperatorProfileTitle;
        $this->response["Title"] = Constant::MemberOperatorProfileTitle;
    }

    public function index()
    {
        // permission
        $permission = $this->permission_model->getPermissionByOperator($this->data["operator"]["idx"]);
        $this->load->library("data_transform/permission");
        $this->data["permission"] = $this->permission->mapping($permission);

        // set js
        $js = array(
            "/apps/js/tms/jquery.check_data",
            "/apps/js/tms/member/profile",
        );
        $this->setJs($js);

        $this->render('member/profile_view', $this->data);
    }

    public function updateOperator()
    {
        if ($this->isAjax()) {
            $this->load->library("check_data/valid");

            $operator = $this->operator_model->getOperatorByIdx($this->data["operator"]["idx"]);

            $fields = array(
                "current_password",
                "password",
                "rpassword",
            );
            $post = $this->input->post($fields);

            $this->valid->setRules("current_password", "required|minLength[6]");
            $this->valid->setMessage("current_password", Constant::MemberOperatorPasswordError);
            $this->valid->setRules("password", "required|minLength[6]");
            $this->valid->setMessage("password", Constant::MemberOperatorPasswordError);
            $this->valid->setRules("rpassword", "required|minLength[6]");
            $this->valid->setMessage("rpassword", Constant::MemberOperatorPasswordError);

            if (!$this->valid->run($post)) {
                $this->response["Message"] = $this->valid->getErrors();
            } else {
                if (md5($post["current_password"]) === $operator["operator_password"]) {
                    if ($post["password"] === $post["rpassword"]) {
                        $updateData = array(
                            "operator_password" => md5($post["password"]),
                        );
                        if ($this->operator_model->updateOperator($this->data["operator"]["idx"], $updateData)) {
                            $this->response["Status"]  = true;
                            $this->response["Message"] = Constant::MemberOperatorChangePassword;
                        } else {
                            $this->response["Message"] = Constant::DatabaseError;
                        }
                    } else {
                        $this->response["Message"] = Constant::MemberOperatorEqualPasswordError;
                    }
                } else {
                    $this->response["Message"] = Constant::MemberOperatorCPasswordError;
                }
            }
        }

        $this->tms_output->output($this->response);
    }
}
