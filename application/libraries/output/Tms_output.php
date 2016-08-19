<?php

class Tms_output extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
        // 設定輸出類型預設值
        $this->outputType = "json";
    }

    /**
     *  輸出訊息
     *
     *  @param $response array 要輸出的資料
     */
    public function output(array $response)
    {
        $this->ci->output->set_status_header(200);

        $this->outputType = strtolower($this->outputType);
        switch ($this->outputType) {
            case 'json':
                $response = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $this->ci->output->set_content_type('application/json', 'utf-8');
                break;
            default:
                $response = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $this->ci->output->set_content_type('application/json', 'utf-8');
                break;
        }

        $this->ci->output->set_output($response);
        $this->ci->output->_display();
        exit;
    }
}
