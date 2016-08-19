<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * --------------------------------
 * 網站設定
 * --------------------------------
 */
$config['ver']  = '1.03';
$config['meta'] = array(
    'title'       => 'TMS管理系統',
    'description' => 'Terminal Management System',
    'author'      => 'TMS',
);

$config['menu'] = array(
    'member'      => array(
        'title'      => '會員中心',
        'icon_class' => 'icon-home',
        'item'       => array(
            'info'   => array(
                'title'      => '基本資料設定',
                'icon_class' => 'icon-home',
                'link'       => '/member/maintain',
            ),
            'assist' => array(
                'title'      => '助理帳號設定',
                'icon_class' => 'icon-home',
                'link'       => '/member/operator',
            ),
        ),
    ),
    'transaction' => array(
        'title'      => '銷售中心',
        'icon_class' => 'icon-home',
        'item'       => array(
            // 'query'    => array(
            //     'title'      => '銷售記錄查詢',
            //     'icon_class' => 'icon-home',
            //     'link'       => '/store/transaction',
            // ),
            'merchant' => array(
                'title'      => '商店管理',
                'icon_class' => 'icon-home',
                'link'       => '/store/merchant/lists',
            ),
        ),
    ),
    'accounting'  => array(
        'title'      => '帳務中心',
        'icon_class' => 'icon-home',
        'item'       => array(
            'transaction' => array(
                'title'      => '交易紀錄查詢',
                'icon_class' => 'icon-home',
                'link'       => '/accounting/transaction/lists',
            ),
            // 'invoice'     => array(
            //     'title'      => '電子發票查詢',
            //     'icon_class' => 'icon-home',
            //     'link'       => '/accounting/invoice',
            // )
        ),
    ),
    'terminal'    => array(
        'title'      => '終端設備管理',
        'icon_class' => 'icon-home',
        'item'       => array(
            'list'  => array(
                'title'      => '終端設備一覽表',
                'icon_class' => 'icon-home',
                'link'       => '/terminal/manage',
            ),
            'apply' => array(
                'title'      => '申請終端設備',
                'icon_class' => 'icon-home',
                'link'       => '/terminal/apply/lists/wait/1',
            ),
        ),
    ),
);

$config['aes_encrypt'] = array(
    'key' => 'f14Ubr9RgocWpKk6VLaTAlnz5PJOSmYw',
    'iv'  => 'x0Ckb4wez1QZW7N5',
);

$config["applyStatus"] = array(
    "wait"    => array(
        "name"   => "待審核",
        "status" => 0,
    ),
    "check"   => array(
        "name"   => "審核中",
        "status" => 1,
    ),
    "setup"   => array(
        "name"   => "派機中",
        "status" => 2,
    ),
    "reject"  => array(
        "name"   => "拒絕申請",
        "status" => 3,
    ),
    "success" => array(
        "name"   => "完成",
        "status" => 4,
    ),
);

$config["transactionStatus"] = array(
    "auth"    => "授權",
    "cancel"  => "取消授權",
    "request" => "請款",
    "refund"  => "退款",
);
