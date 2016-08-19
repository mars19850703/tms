<?php

class Manage extends MY_Controller
{
    private $limit;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('terminal_model');
        $this->load->model('merchant_model');
        $this->load->config('edc_setting', true);

        $this->limit             = 10;
        $this->data['title']     = Constant::TerminalManageTitle;
        $this->response['Title'] = Constant::TerminalManageTitle;
    }

    public function index()
    {
        $this->lists();
    }

    public function lists($page = 1)
    {
        if ($page < 1 || !is_numeric($page)) {
            $this->data['page'] = 1;
        }

        $this->data['page'] = $page;

        // filters
        $this->data['filters']           = $this->input->get(array('terminal_id', 'merchant_id'), true);
        $this->data['filters']['limit']  = $this->limit;
        $this->data['filters']['offset'] = ($page - 1) * $this->limit;
        // filters member_idx
        $this->data['filters']['member_idx'] = $this->data['operator']['member_idx'];

        // apply list
        $this->data['terminals'] = $this->terminal_model->getTerminalListsByFilters($this->data['filters']);
        $this->data['totalPage'] = ceil($this->terminal_model->getLastQueryCount() / $this->data['filters']['limit']);

        // MY_Controller::dumpData($this->data);

        // set js
        $js = array(
            '/global/plugins/jquery-bootpag/jquery.bootpag.min',
            '/apps/js/tms/terminal/manage_list',
        );
        $this->setJs($js);

        $this->render('terminal/manage_list_view', $this->data);
    }

    public function update($terminalIdx = null)
    {
        if (is_null($terminalIdx)) {
            redirect('/terminal/manage/lists');
        }

        $this->data['terminal'] = $this->terminal_model->getTerminalByIdx($terminalIdx);
        if (is_null($this->data['terminal'])) {
            redirect('/terminal/manage/lists');
        }

        // get edc set app
        $this->load->model('edc_app_mapping_model');
        $this->data['app'] = $this->edc_app_mapping_model->getAppDetailByEdcSetIdx($this->data['terminal']['edc_set_idx']);

        $this->data['terminal']['edc_config']        = json_decode($this->data['terminal']['edc_config'], true);
        $this->data['terminal']['edc_client_config'] = json_decode($this->data['terminal']['edc_client_config'], true);

        // 取得可以修改欄位的資料
        $this->data['edc_setting_modified'] = $this->config->item('modified', 'edc_setting');

        // get merchant info
        $this->data['merchant'] = $this->merchant_model->getMerchantByIdx($this->data['terminal']['merchant_idx']);

        // MY_Controller::dumpData($this->data);

        // set css
        $css = array(
            'source' => array(
                '/global/plugins/bootstrap-switch/css/bootstrap-switch.min',
            ),
        );
        $this->setCss($css);
        // set js
        $js = array(
            'source' => array(
                '/global/plugins/bootstrap-switch/js/bootstrap-switch.min',
            ),
            '/apps/js/tms/terminal/manage_update',
        );
        $this->setJs($js);

        $this->render('terminal/manage_update_view', $this->data);
    }

    public function updateEdcSetting()
    {
        if ($this->isAjax()) {
            $terminalCode = $this->input->post('terminal_code', true);
            $merchantId   = $this->input->post('merchantId', true);
            if (is_null($terminalCode) || empty($terminalCode) || strlen($terminalCode) !== 4) {
                $this->response['Message'] = Constant::EdcTerminalCodeError;
            } else {
                if (is_null($merchantId) || empty($merchantId) || strlen($merchantId) !== 7) {
                    $this->response['Message'] = Constant::EdcMerchantIdError;
                } else {
                    $merchant = $this->merchant_model->getMerchantByMerchantId($merchantId);

                    $terminal = $this->terminal_model->getTerminalByMemberIdxAndMerchantIdxAndTerminalCode($this->data['operator']['member_idx'], $merchant['idx'], $terminalCode);
                    if (!is_null($terminal)) {
                        $modified = $this->config->item('modified', 'edc_setting');
                        $server   = json_decode($terminal['edc_config'], true);
                        $client   = json_decode($terminal['edc_client_config'], true);

                        $isModify = false;
                        foreach ($server as $app => $config) {
                            foreach ($config as $configName => $configValue) {
                                if ($app !== 'system') {
                                    $value = $this->input->post('server-' . $app . '-' . $configName, true);
                                    if (isset($modified[$configName])) {
                                        if (is_null($value)) {
                                            if ($modified[$configName]['type'] === 'switch') {
                                                $value = '0';
                                            } else {
                                                $value = '';
                                            }
                                        } else {
                                            if ($modified[$configName]['type'] === 'switch') {
                                                $value = '1';
                                            }
                                        }
                                        if ($server[$app][$configName] !== $value) {
                                            // $isModify = true;
                                            $server[$app][$configName] = $value;
                                        }
                                    }
                                }
                            }
                        }
                        foreach ($client['Application'] as $app => $config) {
                            foreach ($config as $configName => $configValue) {
                                $value = $this->input->post('client-' . $app . '-' . $configName, true);
                                if (isset($modified[$configName])) {
                                    if (is_null($value)) {
                                        if ($modified[$configName]['type'] === 'switch') {
                                            $value = '0';
                                        } else {
                                            $value = '';
                                        }
                                    } else {
                                        if ($modified[$configName]['type'] === 'switch') {
                                            $value = '1';
                                        }
                                    }
                                    if ($client['Application'][$app][$configName] !== $value) {
                                        $isModify                  = true;
                                        $client['Application'][$app][$configName] = $value;
                                    }
                                }
                            }
                        }

                        // MY_Controller::dumpData($server, $client);

                        if ($this->terminal_model->updateTerminalSettingByTerminalIdx($terminal['idx'], $server, $client)) {
                            if ($isModify) {
                                $this->load->model('edc_update_model');
                                $this->edc_update_model->insertEdcConfigUpdate($this->data['operator']['idx'], $terminal);
                            }
                            $this->response['Status']  = true;
                            $this->response['Message'] = Constant::UpdateDataSuccess;
                        } else {
                            $this->response['Message'] = Constant::DatabaseError;
                        }
                    } else {
                        $this->response['Message'] = Constant::EdcTerminalCodeError;
                    }
                }
            }
        }

        $this->tms_output->output($this->response);
    }
}
