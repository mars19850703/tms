<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    protected $language;
    private $errorTimes = 6; // 帳號密碼錯誤次數
    private $expiration = 1800; // 3600秒後才可以再輸入

    public function __construct()
    {
        parent::__construct();
        $m = $this->router->fetch_method();
        if ($this->session->operator && $m == 'index') {
            redirect('/accounting/transaction');
        }

        $this->load->model('login_lock_model');

        $this->lang->load('language', str_replace('/', '', $this->languageFolder));
        $this->language = $this->lang->line('login');
    }

    public function index()
    {
        $data = array();
        $ip   = $this->input->ip_address();
        $now  = time();
        $lock = $this->login_lock_model->getByIp($ip, $now);
        if (!$lock) {
            // if ($this->session->error_times < $this->errorTimes) {
            if ($post = $this->input->post(null, true)) {
                $this->load->model('member_model');
                $this->load->model('operator_model');

                if (empty($post['unino'])) {
                    $post['unino'] = null;
                }

                $operator = $this->member_model->loginMemberOperator($post['unino'], $post['username'], md5($post['password']));

                if (strtolower($post['check_code']) === strtolower($this->session->captcha_word) && !empty($post['check_code']) && !is_null($this->session->captcha_word)) {
                    if ($operator) {
                        $this->session->set_userdata('operator', $operator);
                        // Update Operator.last_login
                        $this->operator_model->update(array('last_login' => date("Y-m-d H:i:s")), array('idx' => $operator['idx']));
                        redirect('/accounting/transaction');
                    } else {
                        $num = ($this->session->error_times + 1);
                        $this->session->set_tempdata('error_times', $num, $this->expiration);
                        // 輸入錯誤次數達到門檻
                        if ($num >= $this->errorTimes) {
                            $this->session->set_tempdata('lock_login', true, $this->expiration);
                            $data['error_msg'] = str_replace('{seconds}', $this->expiration, $this->language['lock_login']);
                            // 寫入Login_lock的table
                            $this->login_lock_model->insert(array(
                                'ip'          => $ip,
                                'lock_time'   => $now + $this->expiration,
                                'create_time' => date("Y-m-d H:i:s"),
                            ));
                        } else {
                            if (isset($post['unino']) && $post['unino']) {
                                $data['error_msg'] = $this->language['enterprise_login_error'];
                            } else {
                                $data['error_msg'] = $this->language['personal_login_error'];
                            }
                        }
                    }
                } else {
                    $num = ($this->session->error_times + 1);
                    $this->session->set_tempdata('error_times', $num, $this->expiration);
                    // 輸入錯誤次數達到門檻
                    if ($num >= $this->errorTimes) {
                        $this->session->set_tempdata('lock_login', true, $this->expiration);
                        $data['error_msg'] = str_replace('{seconds}', $this->expiration, $this->language['lock_login']);
                        // 寫入Login_lock的table
                        $this->login_lock_model->insert(array(
                            'ip'          => $ip,
                            'lock_time'   => $now + $this->expiration,
                            'create_time' => date("Y-m-d H:i:s"),
                        ));
                    }

                    $data['error_msg'] = $this->language['check_code_error'];
                }
            }
        } else {
            if (!$this->session->lock_login) {
                $this->session->set_tempdata('lock_login', true, ($lock['lock_time'] - $now));
            }
            $data['error_msg'] = str_replace('{seconds}', ($lock['lock_time'] - $now), $this->language['lock_login']);
        }

        $data['global']  = $this->config->item('global_common');
        $data['website'] = $this->config->item('website_config');
        $this->load->view($this->languageFolder . 'login_view', $data);
    }

    public function logout()
    {

        $this->session->sess_destroy();

        redirect('login');
    }

    public function captcha()
    {
        $this->load->library('captcha');
        $this->captcha->generate();
    }
}
