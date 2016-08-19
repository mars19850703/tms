<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forget extends MY_Controller
{
    protected $language;
    private $limitSeconds = 3600;
    private $key;
    private $iv;

    public function __construct()
    {
        parent::__construct();
        $this->load->config($this->languageFolder . 'website_config', true);
        $this->load->model(array('member_model', 'operator_model', 'operator_verify_model'));
        $this->load->helper('common');

        $aes_encrypt = $this->config->item('aes_encrypt', $this->languageFolder . 'website_config');
        $this->key   = $aes_encrypt['key'];
        $this->iv    = $aes_encrypt['iv'];

        $this->lang->load('language', str_replace('/', '', $this->languageFolder));
        $this->language = $this->lang->line('forget_lang');
    }

    public function index()
    {
        $this->load->helper('string');
        $data = array();

        if ($post = $this->input->post()) {
            if (!empty($post['username']) && !empty($post['email'])) {
                $where = array('operator_name' => $post['username'], 'operator_email' => $post['email']);
                $data  = $this->member_model->getMemberOperator(null, $post['username'], $post['email']);
                if ($data) {
                    // 產生忘記密碼code
                    $data['operator_code'] = random_string('md5');
                    $data['limit_time']    = time() + $this->limitSeconds;
                    //更新到Operator.operator_code
                    $this->operator_model->update(array('operator_code' => $data['operator_code'], 'code_limit_time' => $data['limit_time']), array('idx' => $data['idx'], 'operator_name' => $data['operator_name']));
                    // 寫到Operator_verify
                    $insertOperatorVerifyData = array(
                        'member_idx'    => $data['idx'],
                        'operator_idx'  => $data['operator_idx'],
                        'verify_type'   => 'forget',
                        'verify_target' => $data['operator_email'],
                        'verify_code'   => $data['operator_code'],
                        'verify_status' => 0,
                        'create_time'   => date("Y-m-d H:i:s"),
                        'ip'            => $this->input->ip_address(),
                    );
                    $this->operator_verify_model->insert($insertOperatorVerifyData);
                    // 寄送Email
                    $this->sendForgetEmail($data);

                    $this->session->set_flashdata('forget_email', $data['operator_email']);
                    redirect('member/forget/sendmail');
                } else {
                    $data['error_msg'] = $this->language['personal_forget_error'];
                }
            } else if (!empty($post['unino']) && !empty($post['username'])) {
                $data = $this->member_model->getMemberOperator($post['unino'], $post['username']);
                if ($data) {
                    // 產生忘記密碼code
                    $data['operator_code'] = random_string('md5');
                    $data['limit_time']    = time() + $this->limitSeconds;
                    // 更新到Operator.operator_code
                    $this->operator_model->update(array('operator_code' => $data['operator_code'], 'code_limit_time' => $data['limit_time']), array('idx' => $data['idx'], 'operator_name' => $data['operator_name']));
                    // 寫到Operator_verify
                    $insertOperatorVerifyData = array(
                        'member_idx'    => $data['idx'],
                        'operator_idx'  => $data['operator_idx'],
                        'verify_type'   => 'forget',
                        'verify_target' => $data['operator_email'],
                        'verify_code'   => $data['operator_code'],
                        'verify_status' => 0,
                        'create_time'   => date("Y-m-d H:i:s"),
                        'ip'            => $this->input->ip_address(),
                    );
                    $this->operator_verify_model->insert($insertOperatorVerifyData);
                    // 寄送Email
                    $this->sendForgetEmail($data);

                    $this->session->set_flashdata('forget_email', $data['operator_email']);
                    redirect('member/forget/sendmail');
                } else {
                    $data['error_msg'] = $this->language['enterprise_forget_error'];
                }
            } else {
                $data['error_msg'] = $this->language['check_input_data'];
            }
        }

        if (!isset($data['operator_code']) && !isset($data['limit_time'])) {
            $data['global'] = $this->config->item('global_common');
            $data['website'] = $this->config->item($this->languageFolder . 'website_config');
            $this->load->view($this->languageFolder.'member/forget_view', $data);
        }

    }

    public function sendmail()
    {
        if ($forget_email = $this->session->flashdata('forget_email')) {
            $data = array(
                'form_title'      => $this->language['sendmail_title'],
                'portlet_caption' => $this->language['sendmail_caption'],
                'form_message'    => str_replace('{email}', $forget_email, $this->language['sendmail_message']),
            );

            $data['global'] = $this->config->item('global_common');
            $data['website'] = $this->config->item($this->languageFolder . 'website_config');
            $this->load->view($this->languageFolder.'member/message_view', $data);
        } else {
            redirect('/');
        }
    }

    public function resetpwd()
    {
        $dataString = $this->uri->segment(4, 0);
        // 解密
        $param = @decryption($this->key, $this->iv, $dataString);
        if ($param !== false) {
            // 查詢資料
            $operator = $this->operator_model->getByParam(false, array('idx' => $param['idx'], 'operator_code' => $param['operator_code']));
            if ($operator) {
                // 檢查忘記密碼的驗證碼，時間是否有過期
                if ($operator['operator_code'] == $param['operator_code']
                    && $operator['code_limit_time'] == $param['limit_time']
                    && time() < $operator['code_limit_time']) {
                    // post update password
                    $isUpdate = false;
                    if ($post = $this->input->post()) {
                        if (!empty($post['forget_data']) && !empty($post['password']) && !empty($post['rpassword'])) {
                            // 確認forget data
                            if ($post['forget_data'] == $dataString && $post['password'] == $post['rpassword']) {
                                $updateOperatorData = array(
                                    'operator_password' => md5($post['password']),
                                    'operator_code'     => null,
                                    'code_limit_time'   => 0,
                                );
                                $where = array(
                                    'idx'           => $param['idx'],
                                    'operator_code' => $param['operator_code'],
                                );
                                $this->operator_model->update($updateOperatorData, $where);

                                // 更新operator_verify
                                $updateOperatorVerifyData = array(
                                    'verify_status' => 1,
                                    'verify_time'   => date("Y-m-d H:i:s"),
                                );
                                $verifyWhere = array(
                                    'verify_code'   => $param['operator_code'],
                                    'verify_target' => $operator['operator_email'],
                                    'verify_type'   => 'forget',
                                    'verify_status' => 0,
                                );
                                $this->operator_verify_model->update($updateOperatorVerifyData, $verifyWhere);

                                $this->session->set_flashdata('reset_pwd_operator_idx', $operator['idx']);
                                redirect('member/forget/resetpwd_submit');
                            } else {
                                // 密碼不相同
                                $data['error_msg'] = $this->language['resetpwd_not_same'];
                            }
                        }
                    }
                    if (!$isUpdate) {
                        $data['global'] = $this->config->item('global_common');
                        $data['website'] = $this->config->item('website_config');
                        $data['forget_data'] = $dataString;
                        $this->load->view($this->languageFolder.'member/forget_resetpwd_view', $data);
                    }
                } else {
                    // 時間過期
                    $data = array(
                        'form_title'      => $this->lang->line('forget'),
                        'portlet_caption' => $this->lang->line('error'),
                        'form_message'    => $this->language['resetpwd_timeout_message'],
                    );
                    $this->load->view($this->languageFolder.'member/message_view', $data);
                }
            } else {
                // 資料不正確
                $data = array(
                    'form_title'      => $this->lang->line('forget'),
                    'portlet_caption' => $this->lang->line('error'),
                    'form_message'    => $this->language['resetpwd_data_error_message'],
                );
                $this->load->view($this->languageFolder.'member/message_view', $data);
            }
        } else {
            // 確認碼不正確
            $data = array(
                'form_title'      => $this->lang->line('forget'),
                'portlet_caption' => $this->lang->line('error'),
                'form_message'    => $this->language['resetpwd_checkcode_error_message'],
            );
            $this->load->view($this->languageFolder.'member/message_view', $data);
        }

    }

    public function resetpwd_submit()
    {
        if ($this->session->flashdata('reset_pwd_operator_idx')) {
            $data = array(
                'form_title'      => $this->language['resetpwd_success'],
                'portlet_caption' => $this->language['resetpwd_success'],
                'form_message'    => $this->language['resetpwd_success_message'],
            );

            $this->load->view($this->languageFolder.'member/message_view', $data);
        } else {
            redirect('/');
        }
    }

    /**
     * 商店表單檢查
     * @return [type] [description]
     */
    private function resetPasswordFormCheck()
    {
        $this->load->library('form_validation');

        // set rule
        $this->form_validation->set_rules('password', '管理密碼', 'required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('rpassword', '確認管理密碼', 'required|matches[password]');

        // set error message
    

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
     * 寄送忘記密碼Email
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function sendForgetEmail($data)
    {
        $this->load->library('email');

        $param = array(
            'idx'           => $data['idx'],
            'operator_code' => $data['operator_code'],
            'limit_time'    => $data['limit_time'],
        );

        $encryptString          = encryption($this->key, $this->iv, $param);
        $forgetPwdUrl           = WEBSITE_DOMAIN . '/member/forget/resetpwd/' . $encryptString;
        $data['forget_pwd_url'] = $forgetPwdUrl;

        $subject     = $this->language['email_subject'];
        $mailContent = $this->load->view($this->languageFolder.'member/forget_email_view', $data, true);

        $notifyEmail = $this->config->item('notify_email', 'global_common');
        $this->email->sendMail(array('email' => $notifyEmail['email'], 'name' => $notifyEmail['name']), array('email' => $data['operator_email']), $subject, $mailContent, 'html');
    }
}
