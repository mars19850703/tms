<?php

class BaseCheck extends BaseLibrary
{

    public function __construct()
    {
        parent::__construct();
    }

    public function required($str)
    {
        $str = trim($str);
        if (strlen($str) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function minLength($str, $length)
    {
        if (mb_strlen($str) >= $length) {
            return true;
        } else {
            return false;
        }
    }

    public function maxLength($str, $length)
    {
        if (mb_strlen($str) <= $length) {
            return true;
        } else {
            return false;
        }
    }

    public function numeric($str)
    {
        return is_numeric($str);
    }

    public function email($email)
    {
        $pattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        return $this->regexTest($pattern, $email);
    }

    public function account($account)
    {
        $pattern = "/^([a-zA-Z0-9_-]{1,32})$/";
        return $this->regexTest($pattern, $account);
    }

    public function merchantEnName($merchantEnName)
    {
        $pattern = "/^[a-zA-Z0-9]{1}[a-zA-Z0-9_\s]{0,}/";
        if ($this->regexTest($pattern, $merchantEnName)) {
            if (strlen($merchantEnName) < 1) {
                return false;
            } else if (strlen($merchantEnName) > 45) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function tel($tel)
    {
        $pattern = "/^0\d{8,9}$/";
        return $this->regexTest($pattern, $tel);
    }

    public function string($string)
    {
        $pattern = "/^([a-zA-Z0-9]+)$/";
        return $this->regexTest($pattern, $string);
    }

    /**
     *  檢查有無 $OrderID，並符合規則
     *
     *  @param $orderId string 商店自定義的訂單編號
     *  @return boolean
     */
    public function validOrderId($orderId)
    {
        $pattern = "/^([a-zA-Z0-9_]{1,16})$/";
        return $this->regexTest($pattern, $orderId);
            
    }

    /**
     *  驗證金額是否為數字，並有包含至小數第二位
     *
     *  @param $amount int 此次交易金額
     *  @return boolean
     */
    public function validAmount($amount)
    {
        $amount_explode = explode(".", $amount);
        if (!is_numeric($amount)) {
            return false;
        }
        if (count($amount_explode) > 2) {
            return false;
        }

        return true;
    }

    /**
     *  驗證手機號碼
     *
     *  @param $mobile string|array 手機號碼
     *  @return boolean
     */
    public function validMobile($mobile)
    {
        // 驗證是否為手機號碼
        if (is_array($mobile)) {
            foreach ($mobile as $m) {
                if (!regexTest('/^09\d{8}$/', trim($m))) {
                    return false;
                }
            }
        } else {
            if (!regexTest('/^09\d{8}$/', trim($mobile))) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Validate URL
     *
     *  @access public
     *  @param string
     *  @return string
     */
    public function validUrl($url)
    {
        $pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        return $this->regexTest($pattern, $url);
    }

    /**
     *  正規表示式
     *
     *  @param $pattern string 正規表示式的規則
     *  @param $string strgin 需要驗證的字串
     *  @return boolean
     */
    protected function regexTest($pattern, $string)
    {
        if (preg_match($pattern, $string) === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  正規表示式，取得規則中的文字
     *
     *  @param {string} $pattern 正規表示式的規則
     *  @param {string} $string 需要驗證的字串
     *  @return {array}
     */
    protected function regexMatch($pattern, $string)
    {
        preg_match($pattern, $string, $match);
        return $match;
    }
}
