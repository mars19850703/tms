<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apply extends MY_Controller
{
    private $limit;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("edc_apply_model");
        $this->load->model("merchant_model");
        $this->load->model("edc_apply_service_model");

        $this->limit               = 10;
        $this->data["title"]       = Constant::TerminalApplyTitle;
        $this->response["Title"]   = Constant::TerminalApplyTitle;
        $this->data["applyStatus"] = $this->config->item("applyStatus", $this->languageFolder . "website_config");
    }

    public function index()
    {
        $this->lists();
    }

    public function lists($type = "wait", $page = 1)
    {
        if ($page < 1 || !is_numeric($page)) {
            $this->data["page"] = 1;
        }

        $this->data["page"] = $page;
        $this->data["type"] = $type;

        // filters
        $this->data["filters"]           = $this->input->get(array("merchant_id"), true);
        $this->data['member_idx']        = $this->data['operator']['member_idx'];
        $this->data["filters"]["limit"]  = $this->limit;
        $this->data["filters"]["offset"] = ($page - 1) * $this->limit;
        $this->data["filters"]["status"] = $this->mappingApplyStatus($type);
        // filters member_idx
        $this->data["filters"]["member_idx"] = $this->data["operator"]["member_idx"];

        // apply list
        $this->data["applys"]    = $this->edc_apply_model->getApplyListByFilters($this->data["filters"]);
        $this->data["totalPage"] = ceil($this->edc_apply_model->getLastQueryCount() / $this->data["filters"]["limit"]);

        // MY_Controller::dumpData($this->data);

        // set js
        $js = array(
            "/global/plugins/jquery-bootpag/jquery.bootpag.min",
            "/apps/js/tms/terminal/apply_list",
        );
        $this->setJs($js);

        $this->render('terminal/apply_list_view', $this->data);
    }

    public function update($applyId = 0)
    {
        $merchantFilters = array(
            "member_idx" => $this->data["operator"]["member_idx"],
        );
        $this->data["merchants"] = $this->merchant_model->getMerchantListByFilters($merchantFilters);

        // apply
        $this->data["apply"] = $this->edc_apply_model->getApplyByApplyId($applyId);

        // load product status config
        $this->config->load('global_status', true);
        $this->data["productCategory"] = $this->config->item("product", "global_status");

        // service
        $this->load->library("data_transform/service");
        // $this->data["services"]     = $this->service->getServiceTreeData();
        $this->data["services"] = $this->service->getServiceTreeData($this->data["productCategory"]);
        // apply service
        $this->data["applyServices"] = $this->service->getApplyServices($this->data["apply"]["idx"]);

        // MY_Controller::dumpData($this->data);

        // set css
        $css = array(
            "source" => array(
                "/global/plugins/jstree/dist/themes/default/style.min",
            ),
        );
        $this->setCss($css);
        // set js
        $js = array(
            "source" => array(
                "/global/plugins/jstree/dist/jstree.min",
            ),
            "/apps/js/tms/jquery.check_data",
            "/apps/js/tms/terminal/apply_update",
        );
        $this->setJs($js);

        $this->render("terminal/apply_update_view", $this->data);
    }

    public function updateApply()
    {
        if ($this->isAjax()) {
            $this->load->library("check_data/valid");
            $applyId = $this->input->post("apply_id", true);
            if (strlen($applyId) === 7 || $applyId === "0") {
                $fields = array(
                    "merchant_id",
                    "edc_quantity",
                    "apply_memo",
                    "services",
                );

                $this->data["post"] = $this->input->post($fields, true);

                $this->valid->setRules("merchant_id", "required|minLength[7]|maxLength[7]");
                $this->valid->setMessage("merchant_id", Constant::StoreMerchantIDError);
                $this->valid->setRules("edc_quantity", "required|numeric");
                $this->valid->setMessage("edc_quantity", Constant::StoreMerchantIDError);
                if ($this->valid->run($this->data["post"])) {
                    // 判斷此商店是否為所其所屬商店
                    $merchant = $this->merchant_model->getMerchantByMerchantId($this->data["post"]["merchant_id"]);
                    if ($merchant["member_idx"] === $this->data["operator"]["member_idx"]) {
                        $services = $this->data["post"]["services"];
                        unset($this->data["post"]["services"]);

                        if ($applyId === "0") {
                            $this->load->library("generate/random");
                            $this->data["post"]["member_idx"]          = $this->data["operator"]["member_idx"];
                            $this->data["post"]["create_operator_idx"] = $this->data["operator"]["idx"];
                            $this->data["post"]["apply_id"]            = $this->random->getApplyId();
                            if ($applyIdx = $this->edc_apply_model->insertEdcApply($this->data["post"])) {
                                $this->response["Status"]  = true;
                                $this->response["Message"] = Constant::InsertDataSuccess;
                            } else {
                                $this->response["Message"] = Constant::DatabaseError;
                            }
                        } else {
                            // 判斷有沒有編輯的權限
                            $apply = $this->edc_apply_model->getApplyByApplyId($applyId);
                            if ($apply["member_idx"] === $this->data["operator"]["member_idx"] && $apply["apply_status"] === "0") {
                                $applyIdx                                  = $apply["idx"];
                                $this->data["post"]["modify_operator_idx"] = $this->data["operator"]["idx"];
                                if ($this->edc_apply_model->updateEdcApply($applyId, $this->data["post"])) {
                                    $this->response["Status"]  = true;
                                    $this->response["Message"] = Constant::UpdateDataSuccess;
                                } else {
                                    $this->response["Message"] = Constant::DatabaseError;
                                }
                            } else {
                                $this->response["Message"] = Constant::PermissionDeinedToUpdate;
                            }
                        }

                        // update service code
                        $this->edc_apply_service_model->updateEdcApplyService($applyIdx, $services);
                    } else {
                        $this->response["Message"] = Constant::StoreMerchantIDError;
                    }
                } else {
                    $this->response["Message"] = $this->valid->getErrors();
                }
            } else {
                $this->response["Massage"] = Constant::TerminalApplyIDError;
            }
        }

        $this->tms_output->output($this->response);
    }

    private function mappingApplyStatus($type)
    {
        if (isset($this->data["applyStatus"][$type])) {
            $status = $this->data["applyStatus"][$type]["status"];
        } else {
            $status = 0;
        }

        return $status;
    }
}
