<?php

class Cryptography extends BaseLibrary
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param $string string 資料字串
     *  @param $blockszie string 加垃圾的 szie
     *  @return string 加完垃圾的資料字串
     */
    private function addPadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
     *  小時代會員送資料的加密機制
     *
     *  @param $key string 加密 key
     *  @param $iv string 加密 iv
     *  @param $data array 需要加密的資料
     *  @return string 加密字串
     */
    public function encryption($key, $iv, array $data, $factor = null)
    {
        $str = json_encode($data);
        $str = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $this->addPadding($str), MCRYPT_MODE_CBC, $iv)));
        if (!is_null($factor)) {
            $timestamp = strtotime($factor->Time);
            // The day of the year (starting from 0)
            $z = date('z', $timestamp);
            // ISO-8601 week number of year, weeks starting on Monday
            $W = date('W', $timestamp);
            // today
            $day = date('Ymd', $timestamp);

            $day = str_split($day);

            $count = 0;
            foreach ($day as $d) {
                $count += $d;
            }
            
            $count  = ($count + intval($z) + intval($W) + intval($factor->Index)) % 6;
            $method = 'addGarbage_' . $count;
            $str    = $this->{$method}($str);
        }

        return $str;
    }

    /**
     *  小時代會員送資料的解密機制
     *
     *  @param $key string 加密 key
     *  @param $iv string 加密 iv
     *  @param $str string 需解密字串
     *  @return string 加密字串
     */
    public function decryption($key, $iv, $str, $factor = null)
    {
        if (!is_null($factor)) {
            $timestamp = strtotime($factor->Time);
            // The day of the year (starting from 0)
            $z = date('z', $timestamp);
            // ISO-8601 week number of year, weeks starting on Monday
            $W = date('W', $timestamp);
            // today
            $day = date('Ymd', $timestamp);

            $day = str_split($day);

            $count = 0;
            foreach ($day as $d) {
                $count += $d;
            }

            $count  = ($count + intval($z) + intval($W) + intval($factor->idx)) % 6;
            $method = 'removeGarbage_' . $count;
            $str    = $this->{$method}($str);
        }

        if (!$str = hex2bin($str)) {
            return false;
        }

        if ($str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv)) {
            $data = $this->removePadding($str);
            return $data;
        } else {
            return false;
        }
    }

    /**
     *  小時代會員送資料的解密機制
     *
     *  @param $key string 加密 key
     *  @param $iv string 加密 iv
     *  @param $str string 需解密字串
     *  @return string 加密字串
     */
    public function decryption_old($key, $iv, $str, $factor = null)
    {
        $method = 'removeGarbage_1';
        $str    = $this->removeGarbage_1($str);

        if (!$str = hex2bin($str)) {
            return false;
        }

        if ($str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv)) {
            $data = $this->removePadding($str);
            return $data;
        } else {
            return false;
        }
    }

    /**
     *  將資料去除垃圾字串
     *
     *  @param $string string 資料字串
     *  @return string 去除垃圾的資料字串
     */
    public function removePadding($string)
    {
        $output = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
        $output = json_decode($output, true);

        return $output;
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_0($string)
    {
        $temp    = str_split($string, 32);
        $garbage = $this->generateRandomString(5);
        return implode($garbage, $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_0($string)
    {
        $temp = str_split($string, 37);
        foreach ($temp as &$t) {
            $t = substr($t, 0, 32);
        }

        return implode('', $temp);
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_1($string)
    {
        $temp = str_split($string, 32);
        krsort($temp);
        return implode("", $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_1($string)
    {
        $endLength = strlen($string) % 32;
        $end = substr($string, 0, $endLength);
        $temp = str_split(substr($string, $endLength), 32);
        krsort($temp);
        return implode('', $temp) . $end;
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_2($string)
    {
        $temp = str_split($string, 32);
        krsort($temp);
        $garbage = $this->generateRandomString(5);
        return implode($garbage, $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_2($string)
    {
        $endLength = strlen($string) % 37;
        $end = substr($string, 0, $endLength);

        $temp = str_split(substr($string, $endLength), 37);
        foreach ($temp as &$t) {
            $t = substr($t, 5);
        }
        krsort($temp);
        
        return implode('', $temp) . $end;
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_3($string)
    {
        $temp    = str_split($string, 16);
        $garbage = $this->generateRandomString(8);
        return implode($garbage, $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_3($string)
    {
        $temp = str_split($string, 24);
        foreach ($temp as &$t) {
            $t = substr($t, 0, 16);
        }
        return implode('', $temp);
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_4($string)
    {
        $temp = str_split($string, 16);
        krsort($temp);
        return implode("", $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_4($string)
    {
        $endLength = strlen($string) % 16;
        $end = substr($string, 0, $endLength);

        $temp = str_split(substr($string, $endLength), 16);
        krsort($temp);
        return implode('', $temp) . $end;
    }

    /**
     *  將資料加上垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 加完垃圾的資料字串
     */
    public function addGarbage_5($string)
    {
        $temp = str_split($string, 16);
        krsort($temp);
        $garbage = $this->generateRandomString(8);
        return implode($garbage, $temp);
    }

    /**
     *  將資料移除垃圾字串
     *
     *  @param {string} $string 資料字串
     *  @return {string} 移除垃圾的資料字串
     */
    public function removeGarbage_5($string)
    {
        $endLength = strlen($string) % 24;
        $end = substr($string, 0, $endLength);

        $temp = str_split(substr($string, $endLength), 24);
        foreach ($temp as &$t) {
            $t = substr($t, 8);
        }
        krsort($temp);
        
        return implode('', $temp) . $end;
    }

    /**
     *  生成隨機數字字串
     *  --  隨機產生長度 6 - 10 的字串，在左邊補零至 10 位數
     *
     *  @return string 隨機字串
     */
    private function generateRandomString($length = 32)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
