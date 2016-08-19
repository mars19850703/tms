<?php

class Valid_test extends BaseCheck
{
    private $rules;
    private $errorField;
    private $errorMsg;
    private $errorMethod;

    public function __construct()
    {
        parent::__construct();
        $this->rules    = array();
        $this->errorMsg = array();
    }

    public function setRules($field, $rule)
    {
        if (is_string($field) && (is_string($rule) || is_array($rule))) {
            $this->rules[] = array($field, $rule);
        }
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function run(array $data)
    {
        // init error field
        $this->errorField = null;

        // MY_Controller::dumpData($this->rules);

        if (!empty($data) && !empty($this->rules)) {
            foreach ($this->rules as $rule) {
                if (is_array($rule[1])) {
                    $condition = $rule[1];
                } else {
                    $condition = explode("|", $rule[1]);
                }

                // MY_Controller::dumpData($condition);

                foreach ($condition as $con) {

                    // var_dump($con);echo '<br/>';

                    if (!is_array($con)) {
                        $length = $this->getLimitLength($con);
                        if ($length) {
                            list($method) = explode('[', $con, 2);
                        } else {
                            $method = $con;
                        }

                        if (method_exists($this, $method)) {
                            if ($length) {
                                if (!$this->$method($data[$rule[0]], $length)) {

                                    // MY_Controller::dumpData($method,$data[$rule[0]], $length);

                                    $this->errorMethod = $method;
                                    $this->errorField = $rule[0];
                                    return false;
                                }
                            } else {
                                if (!$this->$method($data[$rule[0]])) {

                                    // MY_Controller::dumpData($method, $data[$rule[0]]);

                                    $this->errorMethod = $method;
                                    $this->errorField = $rule[0];
                                    return false;
                                }
                            }
                        }
                    } else {

                        // MY_Controller::dumpData();

                        if (!$con[1]($data[$rule[0]])) {

                            // MY_Controller::dumpData($con[1], $rule[0]);

                            $this->errorMethod = $con[0];
                            $this->errorField = $rule[0];
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     *  設定錯誤訊息
     *  
     *  @param {string} $field 欄位名稱或是 method 名稱
     *  @param {string} $msg 錯誤訊息
     */
    public function setMessage($field, $msg)
    {
        if (is_string($field) && is_string($msg)) {
            $this->errorMsg[$field] = $msg;
        }
    }

    public function getErrors()
    {
        if (!is_null($this->errorField)) {
            if (isset($this->errorMsg[$this->errorMethod])) {
                return $this->errorMsg[$this->errorMethod];
            } else {
                if (isset($this->errorMsg[$this->errorField])) {
                    return $this->errorMsg[$this->errorField];
                } else {
                    return sprintf(Constant::ValidErrorDefault, $this->errorField);
                }
            }
        } else {
            return Constant::ValidNoError;
        }
    }

    private function getLimitLength($str)
    {
        $pattern = "/\[(.*?)\]/";
        $match   = $this->regexMatch($pattern, $str);
        if (count($match) === 0) {
            return false;
        } else {
            return $match[1];
        }
    }
}
