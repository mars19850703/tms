<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Set extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getWebSideSetting()
    {
        $this->lang->load("language", substr($this->languageFolder, 0, 2));
        $setting = array(
            "tmsBaseUrl" => $this->config->item("tms_base_url", "global_common"),
            "js"         => $this->lang->line("js"),
        );

        $this->output->set_status_header(200);
        $this->output->set_content_type('application/json', 'utf-8');
        $this->output->set_output(json_encode($setting, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $this->output->_display();
        exit();
    }
}
