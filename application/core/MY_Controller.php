<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller
{
    // 資料物件
    protected $data;
    // 輸出格式
    protected $response;
    // 繼承 MY_Controller 的 Controller Class 名稱
    protected $ctl;
    // 目前作用的Controller Method 名稱
    protected $method;
    // 登入資訊
    protected $admin;
    // user 語言設定
    protected $languageFolder;
    protected $ignoreLogin;
    // minify js/css
    private $js;
    private $css;

    public function __construct()
    {
        parent::__construct();

        $this->data     = array();
        $this->response = array(
            "Status"  => false,
            "Message" => "",
            "Title"   => "",
        );
        $this->ignoreLogin = array(
            "Register",
            "Forget",
            "Login",
            "Set",
            "Test",
        );

        $this->js  = array('minify' => array(), 'source' => array());
        $this->css = array('minify' => array(), 'source' => array());

        $this->setCSS(array(
            'source' => array(
                'global/plugins/fancybox/source/jquery.fancybox',
            ),
        ));

        $this->setJS(array(
            "source" => array(
                "apps/js/tms/general",
            ),
            'global/plugins/bootstrap/js/bootstrap.min',
            'global/plugins/js.cookie.min',
            'global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min',
            'global/plugins/jquery-slimscroll/jquery.slimscroll.min',
            'global/plugins/jquery.blockui.min',
            'global/plugins/uniform/jquery.uniform.min',
            'global/scripts/app.min',
            'layouts/layout3/scripts/layout.min',
            'layouts/layout3/scripts/demo.min',
            'global/plugins/fancybox/source/jquery.fancybox.pack',
            // "/apps/js/tms/jquery.php"
        ));

        // load output library
        $this->load->library("output/tms_output");
        // load acl library
        $this->load->library("acl");
        // 取得目前的使用者語系
        $this->languageFolder = $this->getLanguageFolder();
        // load config
        $this->config->load('global_common', true);
        $this->config->load($this->languageFolder . 'website_config', true);
        // 載入目前語系參數檔
        include_once APPPATH . "lang/" . $this->languageFolder . "Constant.php";
        // 確認使用者是不是需要登入
        $this->checkOperatorLogin();
    }

    /**
     * -------------------------------------------
     *     建立版型
     * -------------------------------------------
     * @param string $view container view file
     * @param string $tpl template view file
     */
    protected function render($view = '', $view_data = array(), $navigation = 'navigation_view', $tpl = 'responsive_tpl')
    {
        // 版型
        $template = 'template/' . $this->languageFolder . "/" . $tpl;

        $data = array_merge(array(
            'title'      => $this->data["title"],
            'page_title' => $this->_setAppTitle($this->data["title"]),
            'admin'      => $this->data["operator"],
            'global'     => $this->config->item('global_common'),
            'website'    => $this->config->item($this->languageFolder . 'website_config'),
            'js'         => $this->_resourceEncode($this->js, "js"),
            // 'js_before'  => isset($this->data["js_before"]) ? $this->data["js_before"]:"",
            // 'js_after'   => isset($this->data["js_after"]) ? $this->data["js_after"]:"",
            'css'        => $this->_resourceEncode($this->css, "css"),
            'ctl'        => $this->ctl,
            'method'     => $this->method,
        ), $view_data);

        // top (notification and login profile)
        $data['top_view'] = $this->load->view($this->languageFolder . 'top_view', $data, true);
        // navigation menu
        $data['navigation_view'] = $this->load->view($this->languageFolder . $navigation, null, true);
        // container view
        $data['container_view'] = $this->load->view($this->languageFolder . $view, $data, true);

        $this->load->view($template, $data);
    }

    /**
     *
     * @param {string || array} $js  js檔案名稱或array
     */
    protected function setJS($js)
    {
        $this->_addResource($js, 'js');
    }

    /**
     *
     * @param {string || array} $css  css檔案名稱或array
     */
    protected function setCSS($css)
    {
        $this->_addResource($css, 'css');
    }

    /**
     * @param string $title
     */
    private function _setAppTitle($title = '')
    {
        $meta            = $this->config->item('meta', $this->languageFolder . 'website_config');
        $title_separator = $this->config->item('title_separator', 'global_common');

        return $title . $title_separator . $meta['title'];
    }

    /**
     *
     * @param {array} $res
     * @param {string} $type "css" || "js"
     */
    private function _addResource($res, $type)
    {

        // $this->dumpData($res, $type);

        if (is_array($res)) {
            foreach ($res as $file) {
                if (is_array($file)) {
                    $this->{$type}['source'][] = "{$file[0]}.{$type}";
                } else {
                    $this->{$type}['minify'][] = "{$file}.{$type}";
                }
            }
        } else {
            $this->{$type}['minify'][] = "{$file}.{$type}";
        }
    }

    /**
     * base64 encode file list
     * @param {array} $arr
     * @return {array}
     */
    private function _resourceEncode($arr, $type)
    {
        $encode = array(
            'minify' => '',
            'source' => '',
        );

        if (count($arr['minify'])) {
            $encode['minify'] = base64_encode(implode(",", $arr['minify']));
        }

        foreach ($arr['source'] as $file) {
            if ($type === "css") {
                $encode['source'] .= ('<link href="' . $this->config->item('resource', 'global_common') . "/" . $file . '" rel="stylesheet" type="text/css" />' . "\n\t");
            } else {
                $encode['source'] .= ('<script src="' . $this->config->item('resource', 'global_common') . "/" . $file . '"></script>' . "\n\t");
            }
        }

        $encode['source'] = trim($encode['source']);

        return $encode;
    }

    protected function error_redirect()
    {
        redirect($this->ctl);
    }

    public function _remap($method, $arguments = array())
    {
        if (method_exists($this, $method)) {
            $this->ctl    = get_class($this);
            $this->method = $method;
            $folder       = str_replace("/", "", $this->router->fetch_directory());

            // $this->dumpData($this->data["operator"], $folder, $this->ctl, $this->method, $arguments);

            if (!in_array($this->ctl, $this->ignoreLogin)) {
                if ($this->acl->isAllowed($folder, strtolower($this->ctl), $this->method, $arguments)) {
                    if (!empty($this->data["operator"])) {
                        return call_user_func_array(array($this, $method), $arguments);
                    } else {
                        redirect("login");
                    }
                } else {
                    if ($this->isAjax()) {
                        $this->response["Message"] = Constant::PermissionDeined;
                        $this->tms_output->output($this->response);
                    } else {
                        show_error($this->method . "：" . Constant::PermissionDeined, 200, $this->ctl);die;
                    }
                }
            } else {
                return call_user_func_array(array($this, $method), $arguments);
            }
        }

        show_404();
    }

    /**
     * 判斷是否為 ajax 送來請求
     * @return boolean
     */
    public function isAjax()
    {
        return $this->input->is_ajax_request();
    }

    public function ajax($ac)
    {
        if ($this->isAjax()) {
            $this->$ac();
        } else {
            $this->response["msg"] = "No Request";
        }
    }

    protected function checkOperatorLogin($action = null)
    {
        if ($this->session->has_userdata("operator")) {
            $this->data["operator"] = $this->session->operator;
        } else {
            if (in_array(get_class($this), $this->ignoreLogin)) {
                $this->data["operator"] = false;
            } else {
                if ($this->isAjax()) {
                    $this->response["Message"] = Constant::ToLoginAgain;
                    $this->response["ToLogin"] = true;
                    $this->tms_output->output($this->response);
                } else {
                    redirect('login');
                }
            }
        }
    }

    /**
     *  取得目前語言設定
     */
    private function getLanguageFolder()
    {
        if ($this->session->has_userdata("language")) {
            $folder = $this->session->language;
        } else {
            /**
             *  判斷目前瀏覽器語系
             */
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            switch ($lang) {
                case "zh":
                    $folder = "zh/";
                    break;
                case "en":
                    $folder = "en/";
                    break;
                default:
                    $folder = "zh/";
                    break;
            }
        }

        return $folder;
    }

    public static function dumpData()
    {
        $data = func_get_args();
        echo "<pre>";
        foreach ($data as $d) {
            var_dump($d);
            echo "<br/>";
        }
        die;
    }

    public static function printData()
    {
        $data = func_get_args();
        echo "<pre>";
        foreach ($data as $d) {
            print_r($d);
            echo "<br/>";
        }
        die;
    }
}
