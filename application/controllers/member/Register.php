<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MY_Controller
{
    protected $language;
    private $registerTempTime        = 600; // 註冊資料暫存時間
    private $OTPTime                 = 300; // OTP的驗證時間
    private $limitVerifyEmailSeconds = 3600; // 註冊Email驗證時間
    private $OTPRsendNum             = 3; // 可重發OTP次數
    private $OTPErrorNum             = 3; // OTP驗證錯誤次數
    private $key;
    private $iv;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('global_status', true);
        $this->load->helper('common');
        $this->load->model(array('member_model', 'operator_model', 'operator_verify_model'));

        $aes_encrypt = $this->config->item('aes_encrypt', $this->languageFolder . 'website_config');
        $this->key   = $aes_encrypt['key'];
        $this->iv    = $aes_encrypt['iv'];

        $this->lang->load('language', str_replace('/', '', $this->languageFolder));
        $this->language             = $this->lang->line('register_lang');
        $this->language['validate'] = $this->lang->line('js');
    }

    public function index($registerType = 'personal')
    {
        $data = array('language' => $this->languageFolder);

        if ($post = $this->input->post()) {
            $isValidate = $this->registerFormCheck();
            if ($isValidate === true) {
                $createTime = date("Y-m-d H:i:s");
                $birthday   = null;
                $idCardDate = null;
                if (!empty($post['birth_year']) && !empty($post['birth_month']) && !empty($post['birth_day'])) {
                    $birthday = date("Y-m-d", mktime(0, 0, 0, $post['birth_month'], $post['birth_day'], $post['birth_year']));
                }
                if (!empty($post['id_card_year']) && !empty($post['id_card_month']) && !empty($post['id_card_day'])) {
                    $idCardDate = date("Y-m-d", mktime(0, 0, 0, $post['id_card_month'], $post['id_card_day'], $post['id_card_year']));
                }
                $unino = (!empty($post['unino'])) ? $post['unino'] : null;
                // 寫入Member
                $insertMemberData = array(
                    'member_id'           => $this->member_model->createMemberId(),
                    'member_name'         => $post['name'],
                    'member_en_name'      => $post['en_name'],
                    'member_phone'        => $post['mobile'],
                    'member_tel'          => (!empty($post['tel'])) ? $post['tel'] : null,
                    'member_identify'     => (!empty($post['idno'])) ? $post['idno'] : null,
                    'id_card_date'        => $idCardDate,
                    'id_card_place'       => (isset($post['id_card_place']))? $post['id_card_place'] : '',
                    'member_birthday'     => $birthday,
                    'member_email'        => $post['email'],
                    'member_company_name' => (!empty($post['fullname'])) ? $post['fullname'] : null,
                    'member_tax_id'       => $unino,
                    'member_type'         => (!empty($post['unino'])) ? '2' : '1', // 1:個人，2:公司
                    'member_memo'         => (!empty($post['unino'])) ? 'Company' : 'Personal',
                    'member_status'       => 8, // OTP瞨證中
                    'create_time'         => $createTime,
                );
                $memberIdx = $this->member_model->insert($insertMemberData);

                // 寫入Operator
                $insertOperatorData = array(
                    'member_idx'        => $memberIdx,
                    'operator_name'     => $post['username'],
                    'operator_password' => md5($post['password']),
                    'operator_email'    => $post['email'],
                    'operator_type'     => 9,
                    'operator_status'   => 8, // OTP驗證中
                    'operator_code'     => '',
                    'create_time'       => $createTime,
                );
                $operatorIdx = $this->operator_model->insert($insertOperatorData);

                $operator = $this->member_model->loginTempMemberOperator($unino, $post['username'], md5($post['password']), 8, 8);
                $this->session->set_tempdata('operator_temp', $operator, $this->registerTempTime);

                //
                $isNextStep    = true;
                $encryptString = encryption($this->key, $this->iv, $post);
                // 把資料存到session
                $this->session->set_tempdata('register_encrypt_data', $encryptString, $this->registerTempTime);
                // 個人要去驗證手機，公司要去建立商店
                if (!empty($post['unino'])) {
                    // 公司
                    $postData['form_action']   = '/member/register/merchant';
                    $postData['merchant_data'] = $encryptString;

                    $this->load->view($this->languageFolder . 'member/register_post_view', $postData);
                } else {
                    // 個人
                    $postData['form_action'] = '/member/register/otp';
                    $postData['otp_data']    = $encryptString;
                    // 發送OTP
                    $this->sendOtp(str_replace('-', '', $post['mobile']));
                    // set session data
                    $limit_time = time() + $this->OTPTime;
                    // OTP到期時間
                    $this->session->set_tempdata('otp_time', $limit_time, $this->OTPTime);

                    $this->load->view($this->languageFolder . 'member/register_post_view', $postData);
                }
            } else {
                $data['error_msg'] = $isValidate;
            }
        }

        if (empty($isNextStep)) {
            $data['global']         = $this->config->item('global_common');
            $data['website']        = $this->config->item('website_config');
            $data['register_terms'] = $this->load->view($this->languageFolder . 'member/register_terms_view', null, true);
            $data['places'] = $this->config->item('pay2go', 'global_status')['card_place'];
            $this->load->view($this->languageFolder . 'member/register_view', $data);
        }
    }

    public function otp()
    {
        $data = array();
        if ($otpString = $this->input->post('otp_data')) {
            // 解密確認
            $postData = decryption($this->key, $this->iv, $otpString);
            if ($postData) {
                $seconds = $this->session->otp_time - time();
                if ($seconds && $seconds > 0) {
                    $showSendOtp = $this->session->tempdata('show_send_otp');
                    if (!$showSendOtp) {
                        $this->session->set_tempdata('show_send_otp', 1, $seconds);
                    }
                    // 檢查是否還可以重發簡訊

                    // set form data
                    $data['mobile']        = $postData['mobile'];
                    $data['stop_time']     = date("i:s", $seconds);
                    $data['show_send_otp'] = ($showSendOtp) ? '0' : '1';
                } else {
                    // 過期
                    redirect('member/register');
                }
            } else {
                $message = array(
                    'form_title'      => $this->lang->line('error'),
                    'portlet_caption' => $this->language['otp_verify_fail'],
                    'form_message'    => $this->language['otp_fail_otp_data_message'], // OTP認證失敗，OTP DATA錯誤
                    'url'             => '/member/register#personal',
                    'link_name'       => $this->language['back_register'],
                );
                $this->session->set_flashdata('register_message', $message);
                redirect('member/register/message');
                // 請確認otp data;
            }
        } else {
            $message = array(
                'form_title'      => $this->lang->line('error'),
                'portlet_caption' => $this->language['otp_verify_fail'],
                'form_message'    => $this->language['otp_fail_no_otp_data_message'], //OTP認證錯誤，無OTP DATA
                'url'             => '/member/register#personal',
                'link_name'       => $this->language['back_register'],
            );
            $this->session->set_flashdata('register_message', $message);
            redirect('member/register/message');
            // 無otp data;
        }

        $data['global']  = $this->config->item('global_common');
        $data['website'] = $this->config->item('website_config');
        $this->load->view($this->languageFolder . 'member/register_otp_view', $data);
    }

    /**
     * OTP驗證頁面
     * @return [type] [description]
     */
    public function otp_validate()
    {
        $this->load->helper('string');
        if ($this->session->otp_time > time()) {
            $reponseData = $this->otpCodeCheck($this->input->post('otp_code'));
            if ($reponseData['Status'] === 'SUCCESS') {
                $verifyData                  = $this->operator_verify_model->getLast('mobile', str_replace('-', '', $this->session->operator_temp['member_phone']), $this->session->otp_time);
                $operator                    = $this->session->tempdata('operator_temp');
                $operator['operator_status'] = 1;
                // 更新狀態
                $this->member_model->update(array('member_status' => 1), array('idx' => $operator['member_idx']));
                $this->operator_model->update(array('operator_status' => 1, 'last_login' => date("Y-m-d H:i:s")), array('idx' => $operator['idx']));
                $this->operator_verify_model->update(array('verify_status' => 1, 'verify_time' => date("Y-m-d H:i:s")), array('idx' => $verifyData['idx']));
                // 重新寫入session
                $this->session->set_userdata('operator', $operator);

                // 寫入Operator_verify註冊的email驗證
                $operator['operator_code'] = random_string('md5');
                $operator['limit_time']    = time() + $this->limitVerifyEmailSeconds;
                $insertOperatorVerifyData  = array(
                    'member_idx'    => $operator['member_idx'],
                    'operator_idx'  => $operator['idx'],
                    'verify_type'   => 'email',
                    'verify_target' => $operator['operator_email'],
                    'verify_code'   => $operator['operator_code'],
                    'verify_status' => 0,
                    'create_time'   => date("Y-m-d H:i:s"),
                    'ip'            => $this->input->ip_address(),
                );
                $this->operator_verify_model->insert($insertOperatorVerifyData);
                // 發驗證信
                $this->sendRegisterEmail($operator);

                // unset tempdata
                $this->session->unset_tempdata('operator_temp');
                $this->session->unset_tempdata('register_encrypt_data');

                $message = array(
                    'form_title'      => $this->language['personal_register'],
                    'portlet_caption' => $this->lang->line('success'),
                    'form_message'    => $this->language['personal_register_finish_message'],
                    'url'             => '/accounting/transaction',
                    'link_name'       => $this->language['into_system'],
                );
                $this->session->set_flashdata('register_message', $message);
                redirect('member/register/message');
                // redirect('store/transaction');
            } else if ($reponseData['Status'] === 'FALSE') {
                $encryptData      = $this->session->tempdata('register_encrypt_data');
                $data['otp_data'] = $encryptData;
                $this->load->view($this->languageFolder . 'member/register_post_view', $data);
            } else {
                // 錯誤，導訊息頁
                $message = array(
                    'form_title'      => $this->language['register_fail'],
                    'portlet_caption' => $this->language['otp_verify_fail'],
                    'form_message'    => $this->language['otp_verify_error_limit_message'],
                    'url'             => '/member/register#personal',
                    'link_name'       => $this->language['back_register'],
                    'call_function'   => 'registerFail',
                );
                $this->session->set_flashdata('register_message', $message);
                redirect('member/register/message');
            }
        } else {
            // 錯誤，過期
            $message = array(
                'form_title'      => $this->language['register_fail'],
                'portlet_caption' => $this->language['otp_verify_fail'],
                'form_message'    => '<p>' . $this->language['otp_timeout'] . '</p>',
                'url'             => '/member/register#personal',
                'link_name'       => $this->language['back_register'],
                'call_function'   => 'registerFail',
            );
            $this->session->set_flashdata('register_message', $message);
            redirect('member/register/message');
        }
    }

    /**
     * 公司建立商店
     * @return [type] [description]
     */
    public function merchant()
    {
        $this->load->helper('string');
        $this->load->model('merchant_model');

        $data           = array();
        $operator       = $this->session->tempdata('operator_temp');
        $merchantString = $this->input->post('merchant_data');
        if ($operator && $merchantString) {
            // 解密確認
            $postData = decryption($this->key, $this->iv, $merchantString);
            if ($postData) {
                if ($this->input->post('name')) {
                    $post       = $this->input->post();
                    $isValidate = $this->merchantFormCheck();
                    if ($isValidate === true) {
                        $isNextStep = true;
                        // 產生key 、 iv
                        // $merchantId = random_string('numeric', 16);
                        $key = random_string('alnum', 32);
                        $iv  = random_string('alnum', 16);

                        $bank = explode('-', $post['bank']);
                        // insert merchant
                        $insertMerchantData = array(
                            'member_idx'             => $operator['member_idx'],
                            'merchant_name'          => $post['name'],
                            'merchant_en_name'       => $post['en_name'],
                            'national_en'            => $post['national_en'],
                            'city_en'                => $post['city_en'],
                            'merchant_status'        => 2,
                            'merchant_id'            => $this->merchant_model->createMerchantId(),
                            'merchant_city'          => $post['city'],
                            'merchant_county'        => $post['county'],
                            'merchant_zipcode'       => $post['zipcode'],
                            'merchant_address'       => $post['address'],
                            'merchant_tel'           => $post['tel'],
                            'merchant_service_email' => $post['email'],
                            'merchant_url'           => $post['merchant_url'],
                            'merchant_type'          => $post['merchant_type'],
                            'business_type'          => $post['business_type'],
                            'bank_code'              => $bank[0],
                            'bank_name'              => $bank[1],
                            'sub_bank_code'          => $post['sub_bank_code'],
                            'bank_account'           => $post['bank_account'],
                            'merchant_key'           => $key,
                            'merchant_iv'            => $iv,
                            'merchant_intro'         => $post['intro'],
                            'create_operator_idx'    => $operator['idx'],
                            'create_time'            => date("Y-m-d H:i:s"),
                        );
                        $idx                         = $this->merchant_model->insert($insertMerchantData);
                        $operator['operator_status'] = 1;
                        // 更新狀態
                        $this->member_model->update(array('member_status' => 1), array('idx' => $operator['member_idx']));
                        $this->operator_model->update(array('operator_status' => 1, 'last_login' => date("Y-m-d H:i:s")), array('idx' => $operator['idx']));
                        // 重新寫入session
                        $this->session->set_userdata('operator', $operator);
                        // unset tempdata
                        $this->session->unset_tempdata('operator_temp');
                        $this->session->unset_tempdata('register_encrypt_data');

                        // 發驗完成註冊通知信
                        $this->sendRegisterEmail($operator);

                        $message = array(
                            'form_title'      => $this->language['enterprise_register'],
                            'portlet_caption' => $this->lang->line('success'),
                            'form_message'    => $this->language['enterprise_register_finish_message'],
                            'url'             => '/accounting/transaction',
                            'link_name'       => $this->language['into_system'],
                        );
                        $this->session->set_flashdata('register_message', $message);
                        redirect('member/register/message');
                        // redirect('store/transaction');
                    } else {
                        $data              = $post;
                        $data['error_msg'] = $isValidate;
                    }
                }
            } else {
                $message = array(
                    'form_title'      => $this->language['merchant_create'],
                    'portlet_caption' => $this->lang->line('error'),
                    'form_message'    => $this->language['merchant_create_merchant_data_error_message'],
                    'url'             => '/member/register#enterprise',
                    'link_name'       => $this->language['back_register'],
                );
                $this->session->set_flashdata('register_message', $message);
                redirect('member/register/message');
            }
        } else {
            $message = array(
                'form_title'      => $this->language['merchant_create'],
                'portlet_caption' => $this->lang->line('error'),
                'form_message'    => $this->language['merchant_create_timeout'],
                'url'             => '/member/register#enterprise',
                'link_name'       => $this->language['back_register'],
            );
            if (!$merchantString) {
                $message['form_message'] = $this->language['merchant_no_data_message'];
            }
            $this->session->set_flashdata('register_message', $message);
            redirect('member/register/message');
        }

        $data['merchant_data'] = $merchantString;
        if (empty($isNextStep)) {
            $data['merchant_type'] = $this->config->item('pay2go', 'global_status')['merchant_type'];
            $data['business_type'] = $this->config->item('pay2go', 'global_status')['business_type'];
            // bank code
            $data['bankCode'] = $this->config->item('bankCode', 'global_status');
            $data['global']   = $this->config->item('global_common');
            $data['website']  = $this->config->item('website_config');
            $this->load->view($this->languageFolder . 'member/register_merchant_view', $data);
        }
    }

    /**
     * [email_verify description]
     * @return [type] [description]
     */
    public function email_verify()
    {
        $data       = array();
        $dataString = $this->uri->segment(4, 0);
        // 解密
        $param = @decryption($this->key, $this->iv, $dataString);
        if ($param !== false && count($param) > 1) {
            // 查詢資料
            $where = array(
                'operator_idx'  => $param['idx'],
                'verify_type'   => 'email',
                'verify_code'   => $param['operator_code'],
                'verify_status' => 0,
            );
            $verifyData = $this->operator_verify_model->getByParam(false, $where);
            if ($verifyData) {
                $operator = $this->operator_model->getByParam(false, array('idx' => $param['idx']));
                // 檢查忘記密碼的驗證碼，時間是否有過期
                if ($verifyData['verify_code'] == $param['operator_code']
                    && time() < $param['limit_time']) {
                    // 更新Operator_verify
                    $updateOperatorVerifyData = array(
                        'verify_status' => 1,
                        'verify_time'   => date("Y-m-d H:i:s"),
                    );
                    $this->operator_verify_model->update($updateOperatorVerifyData, $where);

                    $data = array(
                        'form_title'      => $this->language['email_verify'],
                        'portlet_caption' => $this->lang->line('success'),
                        'form_message'    => $this->language['email_verify_success_message'],
                    );

                } else {
                    $data = array(
                        'form_title'      => $this->language['email_verify'],
                        'portlet_caption' => $this->lang->line('error'),
                    );
                    if ($operator['code_limit_time'] == $param['limit_time']) {
                        $data['form_message'] = $this->language['email_verify_timeount_message'];
                    } else {
                        $data['form_message'] = $this->language['email_verify_checkcode_error_message'];
                    }
                }
            } else {
                // 請確認資料是否正確
                $data = array(
                    'form_title'      => $this->language['email_verify'],
                    'portlet_caption' => $this->lang->line('error'),
                    'form_message'    => $this->language['email_verify_data_error_message'],
                );
            }
        } else {
            // 請確認驗證碼是否正確
            $data = array(
                'form_title'      => $this->language['email_verify'],
                'portlet_caption' => $this->lang->line('error'),
                'form_message'    => $this->language['email_verify_urldata_error_message'],
            );
        }
        $data['global']  = $this->config->item('global_common');
        $data['website'] = $this->config->item($this->languageFolder . 'website_config');
        $this->load->view($this->languageFolder . 'member/message_view', $data);
    }

    /**
     * 錯誤訊息頁
     * @return [type] [description]
     */
    public function message()
    {
        if ($data = $this->session->flashdata('register_message')) {
            $data['global']  = $this->config->item('global_common');
            $data['website'] = $this->config->item($this->languageFolder . 'website_config');
            $this->load->view($this->languageFolder . 'member/message_view', $data);

            if (!empty($data['call_function'])) {
                $this->$data['call_function']();
                echo $data['call_function'];
            }
        } else {
            redirect('member/register');
        }
    }

    /**
     * ajax check username
     * @return string true | false
     */
    public function check_username()
    {
        $response = 'true';

        if ($post = $this->input->post()) {
            $isExist = true;

            if (isset($post['unino'])) {
                $isExist = $this->member_model->existEnterpriseMemberOperator($post['unino'], $post['username']);
            } else if (isset($post['idno'])) {
                $isExist = $this->member_model->existPersonalMemberOperator($post['idno'], $post['username']);
            }

            $response = ($isExist === true) ? $this->language['validate']['username_exist'] : 'true';
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * ajax check idno
     * @return string true | false
     */
    public function check_idno()
    {
        $response = 'true';

        if ($post = $this->input->post()) {

            if (empty($post['idno'])) {
                $response = $this->language['validate']['require_idno']; // 請輸入身份證字號
            } else if (!checkIdentity($post['idno'])) {
                $response = $this->language['validate']['idno_format']; // 身份證字號格式錯誤
            } else {
                $where    = array('member_identify' => $post['idno'], 'member_status !=' => 9);
                $isExist  = $this->member_model->existMemberByParam($where);
                $response = ($isExist === true) ? $this->language['validate']['idno_exist'] : 'true';
            }

        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * ajax check unino
     * @return string true | false
     */
    public function check_unino()
    {
        $response = 'true';

        if ($post = $this->input->post()) {

            if (empty($post['unino'])) {
                $response = $this->language['validate']['require_unino']; // 請輸入統一編號
            } else if (!preg_match('/\d{8}/', trim($post['unino']))) {
                $response = str_replace('{num}', 8, $this->language['validate']['minlength_numeric']); // 請輸入8個數字
            } else {
                $where    = array('member_tax_id' => $post['unino']);
                $isExist  = $this->member_model->existMemberByParam($where);
                $response = ($isExist === true) ? $this->language['validate']['unino_exist'] : 'true';
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * 驗證OTP
     * @return [type] [description]
     */
    public function check_otp()
    {
        $responseData = $this->otpCodeCheck($this->input->get('otp_code'));

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($responseData));
    }

    /**
     * 重新發送OTP
     * @return [type] [description]
     */
    public function resend_otp()
    {
        $responseData = array(
            'Status'   => "FALSE", // SUCCESS：成功，FALSE：錯誤，FAIL：失敗，錯誤次數過多轉頁
            'ErrorMsg' => $this->language['otp_timeout'],
        );
        $mobile   = str_replace('-', '', $this->input->get('mobile'));
        $isMobile = preg_match("/09[0-9]{8}/", $mobile);
        $seconds  = $this->session->tempdata('otp_time') - time();
        if ($seconds && $seconds > 0) {
            $operator = $this->session->tempdata('operator_temp');
            if (isset($operator['member_phone']) && !empty($mobile) && str_replace('-', '', $operator['member_phone']) == $mobile && $isMobile) {
                $num = $this->session->tempdata('otp_send_num');
                if ($num < $this->OTPRsendNum) {
                    // 重送
                    $num += 1;
                    $this->session->set_tempdata('otp_send_num', $num, $seconds);
                    $this->sendOtp($mobile);

                    $responseData['Status']   = 'SUCCESS';
                    $responseData['ErrorMsg'] = '';
                    $responseData['Num']      = ($this->OTPRsendNum - $num);
                } else {
                    // 拒絕
                    $response['Status']       = 'FAIL';
                    $responseData['ErrorMsg'] = $this->language['otp_resend_limit']; // 重發次數超過上限
                }
            } else {
                // 手機不對
                if (!$mobile) {
                    $responseData['ErrorMsg'] = $this->language['otp_require_mobile']; // 請輸入手機號碼
                } else if (!$isMobile) {
                    $responseData['ErrorMsg'] = $this->language['otp_mobile_format']; // 請確認手機號碼格試
                } else {
                    $responseData['ErrorMsg'] = $this->language['otp_different_mobile']; // 手機號碼不同
                }
            }
        } else {
            // 過期
            $responseData['ErrorMsg'] = '過期';
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($responseData));
    }

    /**
     * 註冊失敗，更改狀態
     * @return [type] [description]
     */
    private function registerFail()
    {
        $operator = $this->session->tempdata('operator_temp');
        if ($operator) {
            // 更新Member、Operator的status改成9
            $this->member_model->update(array('member_status' => 9), array('idx' => $operator['member_idx']));
            $this->operator_model->update(array('operator_status' => 9), array('idx' => $operator['idx']));

            // 清除temp session
            $this->session->unset_tempdata('operator_temp');
            $this->session->unset_tempdata('register_encrypt_data');
            $this->session->unset_tempdata('otp_time');
        }
    }

    /**
     * 發送OTP簡訊
     * @param  string $mobile 手機號碼
     * @return [type]         [description]
     */
    private function sendOtp($mobile)
    {
        $this->load->helper('string');
        $operator = $this->session->tempdata('operator_temp');
        if ($operator && $mobile == str_replace('-', '', $operator['member_phone'])) {
            if ($operator) {
                // 產生OTP驗證資料
                $verifyCode = random_string('numeric', 6);
                // 寫入Operator_verify
                $insertVerifyData = array(
                    'member_idx'    => $operator['member_idx'],
                    'operator_idx'  => $operator['idx'],
                    'verify_type'   => 'mobile',
                    'verify_target' => str_replace('-', '', $operator['member_phone']),
                    'verify_code'   => $verifyCode,
                    'create_time'   => date("Y-m-d H:i:s"),
                );
                $result = $this->operator_verify_model->insert($insertVerifyData);
                // post到sms gateway
                switch ($_SERVER['CI_ENV']) {
                    case 'development':
                        $smsGateway = 'http://gateway.dev.wecanpay.com.tw/sms';
                        break;
                    case 'production':
                        $smsGateway = 'https://gateway.wecanpay.com.tw/sms';
                        break;
                    case 'preview':
                        $smsGateway = 'https://gateway.pre.wecanpay.com.tw/sms';
                        break;
                    case 'beta':
                        $smsGateway = 'http://gateway.beta.wecanpay.com.tw/sms';
                        break;
                    default:
                        $smsGateway = 'http://gateway.wecanpay.localhost/sms';
                        break;
                }

                $smsData = array(
                    "Mobile"  => $mobile,
                    'Content' => str_replace('{otp_code}', $verifyCode, $this->language['otp_sms_content']),
                    // 'ResponseUrl' => 'http://gateway.wecanpay.localhost/sms/notify',
                );
                $smsData  = json_encode($smsData);
                $curlData = array(
                    "StoreID"      => '0012348',
                    "ResponseType" => 'json',
                    "HashKey"      => '1234567890123456',
                    "Ver"          => '1.0',
                    "Data"         => $smsData,
                    'Encoding'     => 'utf8',
                );
                $result = curlPost($smsGateway, $curlData);
            }
        }

    }

    /**
     * 檢查OTP
     * @param  [type] $otpCode [description]
     * @return [type]          [description]
     */
    private function otpCodeCheck($otpCode = null)
    {
        $responseData = array(
            'Status'      => "FALSE", // SUCCESS：成功，FALSE：錯誤，FAIL：失敗，錯誤次數過多轉頁
            'ErrorMsg'    => $this->language['otp_timeout'],
            'ValidateNum' => 0,
        );
        // 確認OTP是否還在驗證時間內
        $seconds = $this->session->otp_time - time();
        if ($seconds && $seconds > 0) {
            if ($otpCode) {
                $registerData = decryption($this->key, $this->iv, $this->session->register_encrypt_data);
                // 取手機最後一筆驗證資料
                $verifyData = $this->operator_verify_model->getLast('mobile', str_replace('-', '', $registerData['mobile']), date("Y-m-d H:i:s", $this->session->otp_time));
                if ($verifyData) {
                    // 計算錯誤次數
                    $num = $this->session->otp_input_error_num;
                    // 檢查次數是否還可以驗證
                    if ($num > $this->OTPErrorNum) {
                        $responseData['Status']   = 'FAIL';
                        $responseData['ErrorMsg'] = $this->language['otp_verify_fail'];
                    } else {
                        if ($verifyData['verify_code'] == $otpCode) {
                            $num -= 1;
                            $responseData['Status']   = 'SUCCESS';
                            $responseData['ErrorMsg'] = '';
                        } else {
                            $responseData['ErrorMsg']    = $this->language['otp_code_error']; // 驗證碼錯誤;
                            $responseData['ValidateNum'] = $this->OTPErrorNum - $num;
                        }
                    }
                    $num += 1;
                    if (!$num) {
                        $this->session->set_tempdata('otp_input_error_num', 1, $seconds);
                    } else {
                        $this->session->set_tempdata('otp_input_error_num', $num, $seconds);
                    }
                } else {
                    $responseData['ErrorMsg'] = $this->language['otp_not_apply']; // 無驗證資料
                }

            } else {
                $responseData['ErrorMsg'] = $this->language['otp_code_not_input']; //未填驗證碼
            }
        } else {
            $responseData['ErrorMsg'] = $this->language['otp_timeout']; //驗證碼錯誤, 驗證碼過期
        }

        return $responseData;
    }

    /**
     * 註冊表單檢查
     * @return [type] [description]
     */
    private function registerFormCheck()
    {
        $this->load->library('form_validation');

        $prefix = '';
        if ($this->input->post('unino')) {
            $prefix = $this->language['admin'];
        }

        // 共同欄位
        $this->form_validation->set_rules(
            'username', $this->language['username'],
            array(
                'trim',
                'required',
                'alpha_dash',
                'max_length[20]',
                array(
                    'username_exist',
                    function ($value) {
                        // 檢查帳號是否已被使用
                        if ($this->input->post('unino')) {
                            $isExist = $this->member_model->existEnterpriseMemberOperator($this->input->post('unino'), $value);
                        } else {
                            $isExist = $this->member_model->existPersonalMemberOperator($this->input->post('idno'), $value);
                        }

                        return ($isExist === true) ? false : true;
                    },
                ),
            )
        );
        $this->form_validation->set_rules('password', $this->language['password'], 'required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('rpassword', $this->language['rpassword'], 'required|matches[password]');
        $this->form_validation->set_rules('name', $prefix . $this->language['name'], 'required|max_length[20]');
        $this->form_validation->set_rules('en_name', $this->language['en_name'], 'required|alpha_numeric_spaces|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('email', $prefix . $this->language['email'], 'trim|required|valid_email|max_length[90]');
        $this->form_validation->set_rules('mobile', $prefix . $this->language['mobile'], array(
            'required',
            'min_length[10]',
            'max_length[12]',
            array(
                'mobile_check',
                function ($value) {
                    // 檢查手機是否已被使用
                    
                    return true;
                },
            ),
            array(
                'mobile_format',
                function ($value) {
                    // 檢查格式是否為09xx-xxxxxx                        
                    return preg_match('/^09\d{2}-\d{6}/', trim($value));
                },
            ),
        )
        );

        // 企業
        if ($this->input->post('unino')) {
            $this->form_validation->set_rules('fullname', $this->language['fullname'], 'required|max_length[30]');
            $this->form_validation->set_rules(
                'unino', $this->language['unino'],
                array(
                    'trim',
                    'required',
                    'numeric',
                    'min_length[8]',
                    'max_length[8]',
                    array(
                        'unino_exist',
                        function ($value) {
                            // 檢查統編是否已被使用
                            $where   = array('member_tax_id' => $value, 'member_status !=' => 9);
                            $isExist = $this->member_model->existMemberByParam($where);
                            return ($isExist === true) ? false : true;
                        },
                    ),
                )
            );
            $this->form_validation->set_rules('tel', $this->language['tel'], array(
                'required',
                'trim',                
                array(
                    'tel_format',
                    function ($value) {
                        // 檢查電話格式是否為0x-xxxxxx或09xx-xxxxxx                        
                        return (preg_match('/^0\d{1,2}-\d{6}/', trim($value)) || preg_match('/^09\d{2}-\d{6}/', trim($value)));
                    },
                ),
            )
            );
        } else {
            $this->form_validation->set_rules(
                'idno', $this->language['idno'],
                array(
                    'trim',
                    'required',
                    'alpha_numeric',
                    'min_length[10]',
                    'max_length[10]',
                    array(
                        'idno_exist',
                        function ($value) {
                            // 檢查身份證字號是否已被使用
                            $where   = array('member_identify' => $value, 'member_status !=' => 9);
                            $isExist = $this->member_model->existMemberByParam($where);
                            return ($isExist === true) ? false : true;
                        },
                    ),
                    array(
                        'idno_format',
                        function ($value) {
                            return checkIdentity($value);
                        },
                    ),
                )
            );
            $this->form_validation->set_rules('birth_year', $this->language['birth_year'], 'trim|required|numeric|min_length[4]|max_length[4]');
            $this->form_validation->set_rules('birth_month', $this->language['birth_month'], 'trim|required|numeric|min_length[1]|max_length[2]');
            $this->form_validation->set_rules('birth_day', $this->language['birth_day'], 'trim|required|numeric|min_length[1]|max_length[2]');

            $this->form_validation->set_rules(
                'id_card_year', $this->language['id_card_year'],
                array(
                    'trim',
                    'required',
                    'numeric',
                    'min_length[4]',
                    'max_length[4]',
                    array(
                        'date_check',
                        function ($value) {
                            // 檢查日期是否大於今天
                            // $idCardDate = date('Y-m-d', mktime(0, 0, 0, $this->input->post('id_card_month'), $this->input->post('id_card_day'), $value));
                            $cardTime = mktime(0, 0, 0, $this->input->post('id_card_month'), $this->input->post('id_card_day'), $value);

                            return ($cardTime > time()) ? false : true;
                        },
                    )                    
                )
            );
            $this->form_validation->set_rules('id_card_month', $this->language['id_card_month'], 'trim|required|numeric|min_length[1]|max_length[2]');
            $this->form_validation->set_rules('id_card_day', $this->language['id_card_day'], 'trim|required|numeric|min_length[1]|max_length[2]');
        }

        // set errorw message
        $this->form_validation->set_message('required', '{field} ' . $this->lang->line('required'));
        $this->form_validation->set_message('min_length', '{field} ' . $this->lang->line('min_length'));
        $this->form_validation->set_message('max_length', '{field} ' . $this->lang->line('max_length'));
        $this->form_validation->set_message('username_exist', '{field} ' . $this->language['exist']);
        $this->form_validation->set_message('idno_exist', '{field} ' . $this->language['exist']);
        $this->form_validation->set_message('idno_format', '{field} ' . $this->language['format_error']);
        $this->form_validation->set_message('unino_exist', '{field} ' . $this->language['exist']);
        $this->form_validation->set_message('alpha_dash', '{field} ' . $this->language['alpha_dash']);
        $this->form_validation->set_message('alpha_numeric_spaces', '{field} ' . $this->language['alpha_numeric_spaces']);
        $this->form_validation->set_message('date_check', $this->language['id_card_date'] . $this->language['date_more_than_today']);
        $this->form_validation->set_message('tel_format', $prefix . $this->language['tel'] . $this->language['validate']['tel_format']);
        $this->form_validation->set_message('mobile_format', $prefix . $this->language['mobile'] . $this->language['validate']['mobile_format']);

        // validate
        if ($this->form_validation->run() == false) {
            $errors = strip_tags(validation_errors());
            $errors = str_replace("\n", "<br>", $errors);
            return $errors;
        } else {
            return true;
        }
    }

    /**
     * 商店表單檢查
     * @return [type] [description]
     */
    private function merchantFormCheck()
    {
        $this->load->library('form_validation');

        // set rule
        $this->form_validation->set_rules('name', $this->language['merchant_name'], 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('en_name', $this->language['merchant_en_name'], 'required|alpha_numeric_spaces|max_length[30]');
        $this->form_validation->set_rules('merchant_url', $this->language['merchant_url'], 'valid_url');
        $this->form_validation->set_rules('email', $this->language['merchant_email'], 'trim|required|valid_email|max_length[90]');
        $this->form_validation->set_rules('tel', $this->language['merchant_tel'], 'required|min_length[7]|max_length[12]');

        $this->form_validation->set_rules('city', $this->language['city'], 'required');
        $this->form_validation->set_rules('zipcode', $this->language['zipcode'], 'required|numeric');
        $this->form_validation->set_rules('address', $this->language['address'], 'required|min_length[3]');
        $this->form_validation->set_rules('intro', $this->language['intro'], 'required');

        // set errorw message
        $this->form_validation->set_message('required', '{field} ' . $this->lang->line('required'));
        $this->form_validation->set_message('min_length', '{field} ' . $this->lang->line('min_length'));
        $this->form_validation->set_message('max_length', '{field} ' . $this->lang->line('max_length'));

        // validate
        if ($this->form_validation->run() == false) {
            $errors = strip_tags(validation_errors());
            $errors = str_replace("\n", "<br>", $errors);
            return $errors;
        } else {
            return true;
        }
    }

    private function sendRegisterEmail($data)
    {
        $this->load->library('email');

        $data['domain'] = WEBSITE_DOMAIN;
        if (!empty($data['member_company_name'])) {
            // 企業，註冊完成信，商店建立信件

            $subject     = $this->language['email_enterprise_subject'];
            $mailContent = $this->load->view($this->languageFolder . 'member/register_enterprise_email_view', $data, true);

        } else {
            // 個人，驗證信件
            $param = array(
                'idx'           => $data['idx'],
                'operator_code' => $data['operator_code'],
                'limit_time'    => $data['limit_time'],
            );

            $encryptString            = encryption($this->key, $this->iv, $param);
            $emailVerifyUrl           = WEBSITE_DOMAIN . '/member/register/email_verify/' . $encryptString;
            $data['email_verify_url'] = $emailVerifyUrl;

            $subject     = $this->language['email_personal_subject'];
            $mailContent = $this->load->view($this->languageFolder . 'member/register_personal_email_view', $data, true);
        }

        $notifyEmail = $this->config->item('notify_email', 'global_common');
        $this->email->sendMail(array('email' => $notifyEmail['email'], 'name' => $notifyEmail['name']), array('email' => $data['operator_email']), $subject, $mailContent, 'html');
    }

}
