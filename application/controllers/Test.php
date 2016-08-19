<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // MY_Controller::dumpData($this->data);
    }

    public function index()
    {
        $a = '{"merchant_id":"6770967","edc_quantity":"5","services":["001001001000","002002002001","001003003002","001003003004"],"apply_memo":"","apply_id":"9552598"}';
        $b = '[{"edc_apply_idx":"2","supplier_idx":"1","product_idx":"1","action_idx":"1","option_idx":"0","service_status":"0"},{"edc_apply_idx":"2","supplier_idx":"1","product_idx":"3","action_idx":"3","option_idx":"2","service_status":"0"},{"edc_apply_idx":"2","supplier_idx":"1","product_idx":"3","action_idx":"3","option_idx":"4","service_status":"0"},{"edc_apply_idx":"2","supplier_idx":"2","product_idx":"2","action_idx":"2","option_idx":"1","service_status":"0"}]';
        $c = '[{"edc_apply_idx":2,"supplier_idx":1,"product_idx":1,"action_idx":1,"option_idx":0},{"edc_apply_idx":2,"supplier_idx":2,"product_idx":2,"action_idx":2,"option_idx":1},{"edc_apply_idx":2,"supplier_idx":1,"product_idx":3,"action_idx":3,"option_idx":4}]';

        MY_Controller::dumpData(json_decode($a, true),json_decode($b, true),json_decode($c, true));
    }

    public function regex()
    {
        // $name = 'hello [3],how good is today';
        // preg_match('/\[(.*?)\]/', $name, $match);
        // var_dump($match);
        // $tel = "0976521a32";
        // var_dump(preg_match('/^0\d{8,9}$/', $tel));
        $pattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        var_dump(preg_match($pattern, "mars.lin.0703@gmail"));
    }

    public function check()
    {
        $this->load->library('check_data/valid_test');
        $data = array(
            'test1' => '123',
            'test2' => '2016-05-09',
        );

        $this->valid_test->setRules('test1', "required|minLength[3]|maxLength[3]");
        $this->valid_test->setMessage('test1', 'test1 error');
        $this->valid_test->setRules('test2',
            array(
                'required',
                'minLength[10]',
                'maxLength[10]',
                array(
                    'aaa',
                    function ($value) {
                        // 檢查日期是否大於今天
                        if (strtotime($value) > time()) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                )
            )
        );
        $this->valid_test->setMessage('test2', 'test2 error');
        $this->valid_test->setMessage('aaa', 'aaa error');

        if ($this->valid_test->run($data)) {
            $this->response['Status'] = true;
            $this->response["Message"] = 'SUCCESS';
        } else {
            $this->response["Message"] = $this->valid_test->getErrors();
        }

        $this->tms_output->output($this->response);
    }
}
