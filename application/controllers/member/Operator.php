<?php defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends MY_Controller
{
    private $permissionValue;

    public function __construct()
    {
        parent::__construct();
        // load operator model
        $this->load->model("operator_model");
        // load permission model
        $this->load->model("permission_model");
        // load merchant model
        $this->load->model("merchant_model");
        // load permission array
        $this->config->load('global_permission', true);
        $this->data["permissionMapping"] = $this->config->item("tms", "global_permission");
        $this->permissionValue           = array(
            0, 1, 3,
        );

        $this->data["title"]     = Constant::MemberOperatorTitle;
        $this->response["Title"] = Constant::MemberOperatorTitle;
    }

    public function index()
    {

        $this->data["filters"] = array(
            "member_idx" => intval($this->data["operator"]["member_idx"]),
        );
        $this->data["operators"] = $this->operator_model->getOperatorListByFilters($this->data["filters"]);

        // MY_Controller::dumpData($this->data);

        // set js
        $js = array(
            "/apps/js/tms/member/operator",
        );
        $this->setJs($js);

        $this->render('member/operator_list_view', $this->data);
    }

    public function detail($idx = 0)
    {

    }

    public function update($idx = 0)
    {
        $this->data["assistant"] = $this->operator_model->getOperatorByIdx($idx);
        if (is_null($this->data["assistant"])) {
            $this->data["assistant"]        = array();
            $this->data["operatorMerchant"] = array("*");
        } else {
            // get assistant manage mechant
            $this->data["operatorMerchant"] = $this->permission_model->getOperatorManageMerchantByOperator($idx);
            if (!empty($this->data["operatorMerchant"])) {
                $this->data["operatorMerchant"] = explode(",", $this->data["operatorMerchant"]);
            } else {
                $this->data["operatorMerchant"] = array("*");
            }
        }

        // member merchant
        $this->data["merchants"] = $this->merchant_model->getMerchantByMemberIdx($this->data["operator"]["member_idx"]);

        // permission
        $permission = $this->permission_model->getPermissionByOperator($idx);
        $this->load->library("data_transform/permission");
        $this->data["permission"] = $this->permission->mapping($permission);

        // MY_Controller::dumpData($this->data);

        // set js
        $js = array(
            "/apps/js/tms/jquery.check_data",
            "/apps/js/tms/member/operator_add",
        );
        $this->setJs($js);

        $this->render('member/operator_update_view', $this->data);
    }

    public function updateOperatorInfo()
    {
        if ($this->isAjax()) {
            $this->load->library("check_data/valid");

            $operatorIdx = $this->input->post("operator_idx", true);
            $fields      = array(
                "operator_name",
                "operator_email",
            );

            // 判斷管理商店是選擇全部 or 自選
            $manage   = $this->input->post("manage", true);
            $merchant = $this->input->post("merchant", true);
            $update   = false;
            if ($manage === "1" && !is_null($merchant) && is_array($merchant)) {
                $update = true;
            } else if ($manage === "*") {
                $update = true;
            }

            $this->data["post"] = $this->input->post($fields, true);

            if ($operatorIdx === "0") {
                // 判斷帳號名稱是否已經存在
                if ($this->data["operator"]["member_type"] === "1") {
                    $isNameExist = $this->operator_model->isOperatorNameExistForPersonal($this->data["post"]["operator_name"]);
                } else {
                    $isNameExist = $this->operator_model->isOperatorNameExistForCompany($this->data["operator"]["member_idx"], $this->data["post"]["operator_name"]);
                }
            } else {
                $isNameExist = false;
            }

            // MY_Controller::dumpData((!$isNameExist&&$update));

            if ($update) {
                if (!$isNameExist) {
                    if ($operatorIdx === "0") {
                        if (!is_null($this->data["post"]["operator_name"]) && !empty($this->data["post"]["operator_name"])) {
                            $this->valid->setRules("operator_name", "required|account|minLength[6]|maxLength[20]");
                            $this->valid->setMessage("operator_name", Constant::AccountFormateError);
                        }
                    } else {
                        unset($this->data["post"]["operator_name"]);
                    }

                    if (!is_null($this->data["post"]["operator_email"]) && !empty($this->data["post"]["operator_email"])) {
                        $this->valid->setRules("operator_email", "required|email");
                        $this->valid->setMessage("operator_email", Constant::EmailFormateError);
                    }

                    if (!$this->valid->run($this->data["post"])) {
                        $this->response["Message"] = $this->valid->getErrors();
                    } else {
                        if ($operatorIdx === "0") {
                            // 判斷帳號數量是否超過
                            if (!$this->operator_model->isOperatorQuantityOver($this->data["operator"]["member_idx"])) {
                                $this->data["post"]["member_idx"] = $this->data["operator"]["member_idx"];
                                // 生成隨機密碼
                                $this->load->library("generate/random");
                                $this->data["post"]["operator_password"] = $this->random->getPassword();
                                if ($operatorIdx = $this->operator_model->insertOperator($this->data["post"])) {
                                    $this->updatePermission($operatorIdx, $manage, $merchant);
                                    $this->sendCreateOperatorAccountEmail($this->data["post"]);
                                    $this->response["Status"]  = true;
                                    $this->response["Message"] = Constant::InsertDataSuccess;
                                } else {
                                    $this->response["Message"] = Constant::DatabaseError;
                                }
                            } else {
                                $this->response["Message"] = Constant::MemberOperatorQuantityOver;
                            }
                        } else {
                            // 判斷有沒有編輯權限
                            $operator = $this->operator_model->getOperatorByIdx($operatorIdx);
                            if ($this->data["operator"]["member_idx"] === $operator["member_idx"]) {
                                $this->data["post"]["modify_operator_idx"] = $this->data["operator"]["idx"];
                                if ($this->operator_model->updateOperator($operatorIdx, $this->data["post"])) {
                                    $this->updatePermission($operatorIdx, $manage, $merchant);
                                    $this->response["Status"]  = true;
                                    $this->response["Message"] = Constant::UpdateDataSuccess;
                                } else {
                                    $this->response["Message"] = Constant::DatabaseError;
                                }
                            } else {
                                $this->response["Message"] = Constant::PermissionDeinedToUpdate;
                            }
                        }
                    }
                } else {
                    $this->response["Message"] = Constant::MemberOperatorNameExist;
                }
            } else {
                $this->response["Message"] = Constant::MemberOperatorMerchantDataError;
            }
        }

        $this->tms_output->output($this->response);
    }

    private function updatePermission($operatorIdx, $manage, $merchant)
    {
        if ($manage === "*") {
            $merchant = "*";
        } else {
            $merchant = implode(",", $merchant);
        }
        foreach ($this->data["permissionMapping"] as $categoryName => $category) {
            foreach ($category["action"] as $controllerName => $controller) {
                foreach ($controller["action"] as $methodName => $method) {
                    $permissionValue = $this->input->post($categoryName . "_" . $controllerName . "_" . $methodName, true);

                    if (is_null($permissionValue) || !is_numeric($permissionValue) || !in_array(intval($permissionValue), $this->permissionValue)) {
                        $permissionValue = 0;
                    } else {
                        $permissionValue = intval($permissionValue);
                    }

                    // MY_Controller::dumpData(in_array(intval($permissionValue), $this->permissionValue), intval($permissionValue), $this->permissionValue);

                    $permission = $this->permission_model->getAccessControllerMethod($operatorIdx, SERVICE_NAME, $categoryName, $controllerName, $methodName);

                    // MY_Controller::dumpData($permission);

                    if (is_null($permission)) {
                        $this->permission_model->insertPermission($operatorIdx, SERVICE_NAME, $categoryName, $controllerName, $methodName, $permissionValue, $merchant);
                    } else {
                        $this->permission_model->updatePermission($operatorIdx, SERVICE_NAME, $categoryName, $controllerName, $methodName, $permissionValue, $merchant);
                    }
                }
            }
        }
    }

    public function updateOperatorStatus()
    {
        if ($this->isAjax()) {
            $operatorIdx = $this->input->post("sn", true);
            $operator    = $this->operator_model->getOperatorByIdx($operatorIdx);
            if ($operator["member_idx"] === $this->data["operator"]["member_idx"]) {
                $status = $this->input->post("status", true);

                if (!is_null($status) && is_numeric($status)) {
                    $where = array(
                        "idx" => $operatorIdx,
                    );

                    $updateData = array(
                        "operator_status" => intval($status),
                    );

                    if ($this->operator_model->update($updateData, $where)) {
                        $this->response["Status"]  = true;
                        $this->response["Message"] = Constant::UpdateDataSuccess;
                    } else {
                        $this->response["Message"] = Constant::DatabaseError;
                    }
                } else {
                    $this->response["Message"] = Constant::DataError;
                }
            } else {
                $this->response["Message"] = Constant::PermissionDeinedToUpdate;
            }
        }

        $this->tms_output->output($this->response);
    }

    /**
     * 寄送新帳號密碼Email
     *
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function sendCreateOperatorAccountEmail($data)
    {
        $this->load->library('email');

        $data["login_url"] = WEBSITE_DOMAIN;
        $subject           = Constant::MemberOperatorAccountEmail;
        $mailContent       = $this->load->view($this->languageFolder . 'email/create_operatort_account_email', $data, true);

        // MY_Controller::dumpData($data);

        $this->email->sendMail(array('email' => Constant::CustomerServiceEmail, 'name' => Constant::CustomerServiceName), array('email' => $data['operator_email']), $subject, $mailContent, 'html');
    }
}
