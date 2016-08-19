<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_card extends MY_Controller
{

	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data["title"] = '信用卡請退款作業';
        $view_data = array(
            'a' => 1,
            'b' => 2
        );
        
        $this->render('payment/credit_card_view', $this->data);
    }
}