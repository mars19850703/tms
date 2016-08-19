<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Einvoice extends MY_Controller
{

	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data["title"] = '電子發票查詢';
        $view_data = array(
            'a' => 1,
            'b' => 2
        );
        
        $this->render('payment/credit_card_view', $this->data);
    }
}