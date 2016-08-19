<?php 
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('curlPost')) {
    function curlPost($url, $postData, $ssl = false)
    {
        // 建立CURL連線
        $ch = curl_init();

        // 設定擷取的URL網址
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($ssl) {
            //turning off the server and peer verification(TrustManager Concept).
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //設定CURLOPT_POST 為 1或true，表示要用POST方式傳遞
        curl_setopt($ch, CURLOPT_POST, 1);
        //CURLOPT_POSTFIELDS 後面則是要傳接的POST資料。
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // 執行
        $temp = curl_exec($ch);

        // 關閉CURL連線
        curl_close($ch);

        return $temp;
    }
}


if (!function_exists('checkIdentity')) {
	function checkIdentity($id){
        $id = strtoupper($id);
        //建立字母分數陣列
        $headPoint = array(
            'A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
            'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
            'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
            'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
            'Y'=>12,'Z'=>30
        );
        //建立加權基數陣列
        $multiply = array(8,7,6,5,4,3,2,1);
        //檢查身份字格式是否正確
        if (preg_match("/[A-Z][1-2]\d{8}/",$id) AND strlen($id) == 10){
            //切開字串
            $stringArray = str_split($id);
            //取得字母分數(取頭)
            $total = $headPoint[array_shift($stringArray)];
            //取得比對碼(取尾)
            $point = array_pop($stringArray);
            //取得數字部分分數
            $len = count($stringArray);
            for($j=0; $j<$len; $j++){
                $total += $stringArray[$j]*$multiply[$j];
            }
            //計算餘數碼並比對
            $last = (($total%10) == 0 )? 0: (10 - ( $total % 10 ));

            if ($last != $point) {
                return false;
            } else {
                return true;
            }
        }  else {
            return false;
        }

	}
}

if (!function_exists('encryption')) {
	function encryption($key, $iv, array $data)
    {
        $str = http_build_query($data);
        $str = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, addPadding($str), MCRYPT_MODE_CBC, $iv)));
        return $str;
    }
}

if (!function_exists('decryption')) {
	function decryption($key, $iv, $str)
    {
        if (!$str = hex2bin($str)) {
            return false;
        }

        if ($str  = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv)) {
            $data = removePadding($str);
            return $data;
        } else {
            return false;
        }

    }
}

if (!function_exists('addPadding')) {
	function addPadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
}

if (!function_exists('removePadding')) {
	function removePadding($string)
    {
        parse_str($string, $output);

        foreach ($output as &$o) {
            // $o = trim($o, "\x00..\x1F");
            $o = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $o);
        }

        return $output;
    }
}

if (!function_exists('replaceString')) {
    function replaceString($string, $replace, $start, $count)
    {
        
    }
}

if (!function_exists('randNumber')) {
    /**
     * 亂數產生編號
     * @param  integer $length    長度,幾個字元
     * @param  integer $startNum  rand的起始數字
     * @param  integer $endNum    rand的結束數字
     * @param  string  $padString 不足長度要補的字元
     * @param  [type]  $padType   str_pad的類型
     * @return string             編號
     */
    function randNumber($length = 7, $startNum = 10000, $endNum = 9999999, $padString = '0', $padType = STR_PAD_LEFT)
    {
        $number = rand($startNum, $endNum);
        $number = str_pad($number, $length, $padString, $padType);
        return $number;
    }
}




