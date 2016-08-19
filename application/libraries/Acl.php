<?php

class Acl extends BaseLibrary
{
    private $ignoreMerchantController;

    public function __construct()
    {
        parent::__construct();
        $this->ignoreMerchantController = array(
            "member" => array(
                "maintain",
                "operator",
            )
        );
        // load permission array
        $this->ci->config->load('global_permission', true);
        $this->ci->load->model("permission_model");
    }

    public function isAllowed($folder, $controller, $method, $arguments)
    {
        // MY_Controller::dumpData($folder, $controller, $method, $arguments);

        $user = $this->ci->session->userdata("operator");
        if (isset($user["operator_status"]) && $user["operator_status"] === "1") {
            if (isset($user["operator_type"])) {
                if ($user["operator_type"] === "9") {
                    return true;
                } else {
                    // tms mapping transform
                    $mappingTransform = $this->ci->config->item("tms_mapping_transform", "global_permission");
                    // tms mapping
                    $mapping = $this->ci->config->item("tms_mapping", "global_permission");
                    if (isset($mappingTransform[$folder][$controller][$method])) {
                        $methodMapping = $mappingTransform[$folder][$controller][$method];
                    } else {
                        $methodMapping = "";
                    }
                    $allow = $this->ci->permission_model->getAccessControllerMethod($user["idx"], SERVICE_NAME, $folder, $controller, $methodMapping);
                    if (isset($this->ignoreMerchantController[$folder]) && in_array($controller, $this->ignoreMerchantController[$folder])) {
                        if ((intval($allow["allowed"]) & intval($mapping[$folder][$controller][$method])) !== 0) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        if ($allow["merchant_id"] === "*") {
                            $merchant = true;
                        } else {
                            $merchants = explode(",", $allow["merchant_id"]);
                            if (isset($arguments[0]) && in_array($arguments[0], $merchants)) {
                                $merchant = true;
                            } else {
                                $merchant = false;
                            }
                        }
                        
                        if ($merchant) {
                            if ((intval($allow["allowed"]) & intval($mapping[$folder][$controller][$method])) !== 0) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                return false;
            }
        } else {
            redirect("logout");
        }
    }
}
