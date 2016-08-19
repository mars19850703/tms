<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('merchant_model');

        $this->limit                     = 10;
        $this->data['title']             = Constant::AccountingTransactionTitle;
        $this->response['Title']         = Constant::AccountingTransactionTitle;
        $this->data['transactionStatus'] = $this->config->item('transactionStatus', $this->languageFolder . 'website_config');
    }

    public function index()
    {
        $this->lists();
    }

    public function lists()
    {
        $this->data['filters'] = $this->input->get(array('start', 'end', 'merchant_id', 'terminal_id', 'type'), true);

        // get merchant list
        $this->data['merchants'] = $this->merchant_model->getMerchantByMemberIdx($this->data['operator']['member_idx']);

        // set css
        $css = array(
            'source' => array(
                '/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min',
            ),
        );
        $this->setCss($css);
        // set js
        $js = array(
            '/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min',
            '/global/plugins/jquery-bootpag/jquery.bootpag.min',
            '/apps/js/tms/accounting/transaction_list',
        );
        $this->setJs($js);

        $this->render('accounting/transaction_list_view', $this->data);
    }

    public function detail($transactionNo)
    {
        $this->data['auth'] = $this->auth_model->getAuthByMemberIdxAndTransactionNo($this->data['operator']['member_idx'], $transactionNo);

        if (!is_null($this->data['auth'])) {
            $this->load->model('cancel_model');
            $this->load->model('request_model');
            $this->load->model('refund_model');
            $this->data['cancel']  = $this->cancel_model->getCancelByAuthIdx($this->data['auth']['idx']);
            $this->data['request'] = $this->request_model->getRequestByAuthIdx($this->data['auth']['idx']);
            $this->data['refund']  = $this->refund_model->getRefundByAuthIdx($this->data['auth']['idx']);

            // MY_Controller::dumpData($this->data);

            // set js
            $js = array(
                '/apps/js/tms/accounting/transaction_detail',
            );
            $this->setJs($js);

            $this->render('accounting/transaction_detail_view', $this->data);
        } else {
            redirect('/accounting/transaction/lists');
        }
    }

    public function getTransactions()
    {
        if ($this->isAjax()) {
            // filters
            $this->data['filters'] = $this->input->post(array('type', 'terminal_id', 'merchant_id', 'start', 'end', 'page'), true);

            // type
            if (empty($this->data['filters']['type'])) {
                $this->data['filters']['type'] = 'auth';
            }

            // page
            if (empty($this->data['filters']['page'])) {
                $this->data['filters']['page'] = 1;
            }
            $this->data['filters']['limit']  = $this->limit;
            $this->data['filters']['offset'] = ($this->data['filters']['page'] - 1) * $this->limit;

            // filters auth status
            $this->data['filters']['status'] = 1;

            // filters member_idx
            $this->data['filters']['member_idx'] = $this->data['operator']['member_idx'];

            // transactions list
            $this->data['auths'] = $this->auth_model->getTransactionListsByFilters($this->data['filters']);

            // MY_Controller::dumpData($this->db->last_query(), $this->data);

            $this->data['totalPage'] = ceil($this->auth_model->getLastQueryCount() / $this->data['filters']['limit']);

            // load view
            $this->response['transaction'] = $this->load->view($this->languageFolder . 'accounting/transaction_list_table_view', $this->data, true);

            $this->response['Status'] = true;
        }

        $this->tms_output->output($this->response);
    }

    public function toAction()
    {
        if ($this->isAjax()) {
            // filters
            $this->data['posts'] = $this->input->post(array('type', 'action', 'amount'), true);

            // MY_Controller::dumpData($this->data);

            // $key = 'tZT07t9z5PxvMVN1YBJRtqzhaaZJo1pS';
            // $iv  = '1jT8N2HSSfoFacH8';

            $this->load->library('cryptography/cryptography');
            $this->load->model('terminal_model');
            $this->load->model('edc_model');
            $this->load->helper(array('common'));
            $url  = $this->config->item('gateway', 'global_common') . 'payment/group';
            $post = array(
                'ResType' => 'json',
            );
            if (!is_null($this->data['posts']['type'])) {
                if ($this->data['posts']['type'] === 'request' || $this->data['posts']['type'] === 'refund' || $this->data['posts']['type'] === 'cancel') {
                    foreach ($this->data['posts']['action'] as $transactionNo) {
                        $auth                               = $this->auth_model->getAuthByMemberIdxAndTransactionNo($this->data['operator']['member_idx'], $transactionNo);
                        $merchant                           = $this->merchant_model->getMerchantByMerchantId($auth['merchant_id']);
                        $terminal                           = $this->terminal_model->getTerminalByMemberIdxAndMerchantIdxAndTerminalCode($this->data['operator']['member_idx'], $merchant['idx'], $auth['terminal_code']);
                        $edc                                = $this->edc_model->getEdcByIdx($terminal['edc_idx']);
                        $data                               = array();
                        $data[$this->data['posts']['type']] = array(
                            'OrderID'     => $auth['order_id'],
                            'Currency'    => $auth['currency'],
                            'Amount'      => (is_null($this->data['posts']['amount'])) ? $auth['amount'] : $this->data['posts']['amount'],
                            'ServiceCode' => str_pad($auth['supplier_idx'], 3, '0', STR_PAD_LEFT) . str_pad($auth['product_idx'], 3, '0', STR_PAD_LEFT) . str_pad($auth['action_idx'], 3, '0', STR_PAD_LEFT) . str_pad($auth['option_idx'], 3, '0', STR_PAD_LEFT),
                            'EDCID'       => $edc['edc_id'],
                            'EDCMac'      => $edc['edc_mac'],
                            'is_tms'      => 1,
                            'AppName'     => $auth['app_name'],
                        );

                        // 如果不是請款，去取得相對應的 service code
                        if ($this->data['posts']['type'] !== 'request') {
                            $this->load->model('option_model');
                            $option                                            = $this->option_model->getOptionByService($auth['supplier_idx'], $auth['product_idx'], $auth['action_idx'], $this->data['posts']['type']);
                            $data[$this->data['posts']['type']]['ServiceCode'] = str_pad($auth['supplier_idx'], 3, '0', STR_PAD_LEFT) . str_pad($auth['product_idx'], 3, '0', STR_PAD_LEFT) . str_pad($auth['action_idx'], 3, '0', STR_PAD_LEFT) . str_pad($option['idx'], 3, '0', STR_PAD_LEFT);
                        }

                        $post['MerchantID'] = $auth['merchant_id'];
                        $post['TerminalID'] = $auth['terminal_code'];
                        $post['Gateway']    = $auth['gateway_version'];

                        // MY_Controller::dumpData($post, $data);

                        // get key by KeyServer
                        $factor        = json_decode(file_get_contents($this->config->item('key_server', 'global_common') . 'key/generate'));
                        $post['_Data'] = $this->cryptography->encryption($factor->Key, $factor->Iv, $data, $factor);
                        $post['KI']    = $factor->Index;
                        $result        = json_decode(curlPost($url, $post));

                        // $result        = curlPost($url, $post);
                        // MY_Controller::dumpData($url, $post, $result);

                        if ($this->data['posts']['type'] === 'request') {
                            if ($result->request->Status === '00000') {
                                $this->response['Message'] .= $auth['order_id'] . ' 請款成功' . '<br/>';
                            } else {
                                $this->response['Message'] .= $auth['order_id'] . ' 請款失敗' . '<br/>';
                            }
                        } elseif ($this->data['posts']['type'] === 'refund') {
                            if ($result->refund->Status === '00000') {
                                $this->response['Message'] .= $auth['order_id'] . ' 退款成功' . '<br/>';
                            } else {
                                $this->response['Message'] .= $auth['order_id'] . ' 退款失敗' . '<br/>';
                            }
                        } elseif ($this->data['posts']['type'] === 'cancel') {
                            if ($result->cancel->Status === '00000') {
                                $this->response['Message'] .= $auth['order_id'] . ' 取消授權成功' . '<br/>';
                            } else {
                                $this->response['Message'] .= $auth['order_id'] . ' 取消授權失敗' . '<br/>';
                            }
                        }
                    }

                    $this->response['Status'] = true;
                }
            }
        }

        $this->tms_output->output($this->response);
    }
}
