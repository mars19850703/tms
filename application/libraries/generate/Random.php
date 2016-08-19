<?php

class Random extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

	public function getPassword()
	{
		return $this->string(8);
	}

    public function getMerchantId()
    {
        $str = $this->randomNum(10000, 9999999);
        $str = str_pad($str, 7, "0", STR_PAD_LEFT);
        $this->ci->load->model("merchant_model");
        if ($this->ci->merchant_model->isMerchantIdExist($str)) {
            $this->getMerchantId();
        } else {
            return $str;
        }
    }

    public function getMerchantKey()
    {
        return $this->string(32);
    }

    public function getMerchantIv()
    {
        return $this->string(16);
    }

    public function getApplyId()
    {
        $str = $this->randomNum(10000, 9999999);
        $str = str_pad($str, 7, "0", STR_PAD_LEFT);
        $this->ci->load->model("edc_apply_model");
        if ($this->ci->edc_apply_model->isApplyIdExist($str)) {
            $this->getApplyId();
        } else {
            return $str;
        }
    }

    /**
     *  生成隨機數字字串
     *
     *	@param {int} $length 字串長度
     *  @return {string} 隨機字串
     */
    public function string($length)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function randomNum($start, $end)
    {
        return rand($start, $end);
    }
}
