<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merchant extends MY_Controller
{
    private $limit;

    public function __construct()
    {
        parent::__construct();
        $this->config->load('global_status', true);
        $this->load->model("merchant_model");

        $this->limit             = 10;
        $this->data["title"]     = Constant::StoreMerchantTitle;
        $this->response["Title"] = Constant::StoreMerchantTitle;
    }

    public function index()
    {
        $this->lists();
    }

    public function lists($page = 1)
    {
        if ($page < 1 || !is_numeric($page)) {
            $page = 1;
        }

        $this->data["page"] = $page;

        // filters
        $this->data["filters"]           = $this->input->get(array("merchant", "keyword"), true);
        $this->data["filters"]["limit"]  = 10;
        $this->data["filters"]["offset"] = ($page - 1) * $this->limit;

        // member filter
        $this->data["filters"]["member_idx"] = $this->data["operator"]["member_idx"];

        // get merchant lists
        $this->data["merchants"] = $this->merchant_model->getMerchantListByFilters($this->data["filters"]);
        $this->data["totalPage"] = ceil($this->merchant_model->getLastQueryCount() / $this->data["filters"]["limit"]);

        // MY_Controller::dumpData($this->data);
        
        $js = array(
            "/global/plugins/jquery-bootpag/jquery.bootpag.min",
            "/apps/js/tms/store/merchant_list"
        );
        $this->setJs($js);

        $this->render('store/merchant_list_view', $this->data);
    }

    public function update($merchantId = 0)
    {
        if (strlen($merchantId) !== 7) {
            $merchantId = 0;
        }

        // merchant config
        $this->data["merchant_config"] = $this->config->item('pay2go', 'global_status');

        // bank code
        $this->data["bankCode"] = $this->config->item('bankCode', 'global_status');

        // merchant
        $this->data["merchant"] = $this->merchant_model->getMerchantByMerchantId($merchantId);

        // MY_Controller::dumpData($this->data);

        // set js
        $js = array(
            "source" => array(
                "global/plugins/jstree/dist/jstree.min",
            ),
            "/apps/js/tms/jquery.check_data",
            "/apps/js/tms/aj-address",
            "/apps/js/tms/store/merchant_update",
        );
        $this->setJs($js);
        $css = array(
            "source" => array(
                "global/plugins/jstree/dist/themes/default/style.min",
            ),
        );
        $this->setCss($css);

        $this->render("store/merchant_update_view", $this->data);
    }

    public function updateMerchant()
    {
        $merchantId = $this->input->post("merchant_id", true);

        if ($this->isAjax()) {
            $this->load->library("check_data/valid");
            if (strlen($merchantId) === 7 || $merchantId === "0") {
                $fields = array(
                    "merchant_name",
                    "merchant_en_name",
                    "merchant_key",
                    "merchant_iv",
                    "merchant_tel",
                    'national_en',
                    'city_en',
                    "merchant_zipcode",
                    "merchant_city",
                    "merchant_county",
                    "merchant_address",
                    "merchant_service_email",
                    'bank',
                    'sub_bank_code',
                    'bank_account',
                    'merchant_type',
                    'business_type',
                    "merchant_url",
                    "merchant_intro",
                );

                $this->data["post"]               = $this->input->post($fields, true);
                $this->data["post"]["member_idx"] = $this->data["operator"]["member_idx"];

                $insert = false;
                $bankStatus = false;
                if ($merchantId === "0") {
                    $insert = true;
                    // generate key & iv
                    $this->load->library("generate/random");
                    $this->data["post"]["merchant_id"]         = $this->random->getMerchantId();
                    $this->data["post"]["merchant_key"]        = $this->random->getMerchantKey();
                    $this->data["post"]["merchant_iv"]         = $this->random->getMerchantIv();
                    $this->data["post"]["merchant_status"]     = 2;
                    $this->data["post"]["create_operator_idx"] = $this->data["operator"]["idx"];

                    // set add valid Rule & Message
                    $this->valid->setRules("merchant_name", "required|minLength[1]|maxLength[45]");
                    $this->valid->setMessage("merchant_name", Constant::StoreMerchantNameFormatError);

                    $this->valid->setRules("merchant_en_name", "required|minLength[1]|maxLength[45]|merchantEnName");
                    $this->valid->setMessage("merchant_en_name", Constant::StoreMerchantEnNameFormatError);
                    
                    $this->valid->setRules("national_en", "required|maxLength[32]|string");
                    $this->valid->setMessage("national_en", Constant::StoreMerchantNationalFormatError);
                    
                    $this->valid->setRules("city_en", "required|minLength[1]|maxLength[45]");
                    $this->valid->setMessage("city_en", Constant::StoreMerchantCityFormatError);
                    
                    $bankTemp = explode('-', $this->data["post"]["bank"]);
                    $this->data["post"]['bank_code'] = $bankTemp[0];
                    $this->valid->setRules("bank_code", "required|minLength[3]|maxLength[3]|numeric");
                    $this->valid->setMessage("bank_code", Constant::StoreMerchantBankCodeFormatError);

                    $this->data["post"]['bank_name'] = $bankTemp[1];
                    $this->valid->setRules("bank_name", "required|minLength[3]|maxLength[45]");
                    $this->valid->setMessage("bank_name", Constant::StoreMerchantBankNameFormatError);

                    // load bank config
                    $bankCode = $this->config->item('bankCode', 'global_status');
                    foreach ($bankCode as $bank) {
                        if ($bank['code'] == $this->data["post"]['bank_code'] && $bank['name'] == $this->data["post"]['bank_name']) {
                            $bankStatus = true;
                        }
                    }
                    
                    $this->valid->setRules("sub_bank_code", "required|minLength[4]|maxLength[4]|numeric");
                    $this->valid->setMessage("sub_bank_code", Constant::StoreMerchantSubBankCodeFormatError);
                    
                    $this->valid->setRules("bank_account", "required|maxLength[25]|numeric");
                    $this->valid->setMessage("bank_account", Constant::StoreMerchantBankAccountFormatError);
                    
                    $this->valid->setRules("merchant_type", "required|minLength[1]|maxLength[1]|numeric");
                    $this->valid->setMessage("merchant_type", Constant::StoreMerchantTypeFormatError);
                    
                    $this->valid->setRules("business_type", "required|minLength[4]|maxLength[4]|numeric");
                    $this->valid->setMessage("business_type", Constant::StoreMerchantBusinessTypeFormatError);
                    
                    $this->valid->setRules("merchant_tel", "required|minLength[9]|maxLength[10]|tel");
                    $this->valid->setMessage("merchant_tel", Constant::TelFormateError);

                    $this->valid->setRules("merchant_zipcode", "required|minLength[3]|maxLength[3]|numeric");
                    $this->valid->setMessage("merchant_zipcode", Constant::ZipcodeFormatError);
                    
                    $this->valid->setRules("merchant_city", "required|minLength[3]");
                    $this->valid->setMessage("merchant_city", Constant::CityFormatError);
                    
                    $this->valid->setRules("merchant_county", "required|minLength[2]");
                    $this->valid->setMessage("merchant_county", Constant::CountyFormatError);
                    
                    $this->valid->setRules("merchant_address", "required|minLength[5]");
                    $this->valid->setMessage("merchant_address", Constant::AddressLengthNotEnough);
                } else {
                    $bankStatus = true;
                    unset($this->data["post"]["merchant_name"]);
                    unset($this->data["post"]["merchant_en_name"]);
                    unset($this->data["post"]["national_en"]);
                    unset($this->data["post"]["city_en"]);
                    unset($this->data["post"]["sub_bank_code"]);
                    unset($this->data["post"]["bank_account"]);
                    unset($this->data["post"]["merchant_type"]);
                    unset($this->data["post"]["business_type"]);
                    unset($this->data["post"]["merchant_tel"]);
                    $this->valid->setRules("merchant_key", "required|minLength[32]|maxLength[32]|string");
                    $this->valid->setMessage("merchant_key", Constant::KeyFormatError);
                    $this->valid->setRules("merchant_iv", "required|minLength[16]|maxLength[16]|string");
                    $this->valid->setMessage("merchant_iv", Constant::IvFormatError);
                }
                unset($this->data["post"]["bank"]);

                
                $this->valid->setRules("merchant_service_email", "required|email");
                $this->valid->setMessage("merchant_service_email", Constant::EmailFormateError);
                if (!empty($this->data["post"]["merchant_url"])) {
                    $this->valid->setRules("merchant_url", "required|validUrl");
                    $this->valid->setMessage("merchant_url", Constant::UrlFormatError);
                }

                if ($this->valid->run($this->data["post"])) {
                    if ($bankStatus) {
                        if ($insert) {
                            if ($this->merchant_model->insertMerchant($this->data["post"])) {
                                $this->response["Status"]  = true;
                                $this->response["Message"] = Constant::InsertDataSuccess;
                            } else {
                                $this->response["Message"] = Constant::DatabaseError;
                            }
                        } else {
                            // 判斷有沒有編輯的權限
                            $merchant = $this->merchant_model->getMerchantByMerchantId($merchantId);
                            if ($merchant["member_idx"] === $this->data["operator"]["member_idx"]) {
                                $this->data["post"]["modify_operator_idx"] = $this->data["operator"]["idx"];
                                if ($this->merchant_model->updateMerchant($merchantId, $this->data["post"])) {
                                    $this->response["Status"]  = true;
                                    $this->response["Message"] = Constant::UpdateDataSuccess;
                                } else {
                                    $this->response["Message"] = Constant::DatabaseError;
                                }
                            } else {
                                $this->response["Message"] = Constant::PermissionDeinedToUpdate;
                            }
                        }
                    } else {
                        $this->response["Message"] = Constant::StoreMerchantBankCodeFormatError;
                    }
                } else {
                    $this->response["Message"] = $this->valid->getErrors();
                }
            } else {
                $this->response["Massage"] = Constant::StoreMerchantIDError;
            }
        }

        $this->tms_output->output($this->response);
    }

    public function getKeyIv()
    {
        if ($this->isAjax()) {
            // generate key & iv
            $this->load->library("generate/random");
            $this->response["Status"] = true;
            $this->response["key"] = $this->random->getMerchantKey();
            $this->response["iv"]  = $this->random->getMerchantIv();
        }

        $this->tms_output->output($this->response);
    }

    public function updateMerchantStatus()
    {
        if ($this->isAjax()) {
            $merchantId = $this->input->post("sn", true);
            $merchant    = $this->merchant_model->getMerchantByMerchantId($merchantId);
            if ($merchant["member_idx"] === $this->data["operator"]["member_idx"]) {
                $status = $this->input->post("status", true);

                if (!is_null($status) && is_numeric($status)) {
                    $where = array(
                        "merchant_id" => $merchantId,
                    );

                    $updateData = array();
                    if ($status === "1") {
                        $updateData["merchant_status"] = 2;
                    } else {
                        $updateData["merchant_status"] = 7;
                    }


                    if ($this->merchant_model->update($updateData, $where)) {
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
}
