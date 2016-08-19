<?php

$lang['forget']     = '忘記密碼';
$lang['error']      = '錯誤';
$lang['success']    = '成功';
$lang['required']   = '必填';
$lang['min_length'] = '最少需要輸入 {param} 字元';
$lang['max_length'] = '最多只能輸入 {param} 字元';

/**
 * js
 */
$lang['js'] = array(
    // system
    'success'                        => "成功",
    'error'                          => "錯誤",
    'ajax_error'                     => '網路可能不夠順暢，請稍後在嘗試。',
    'ajax_callback_error'            => '所指定的function無法正常運作。',
    // 欄位
    'idno'                           => '身份證字號',
    'unino'                          => '統一編號',
    'member_service'                 => '會員條款',
    'privacy_service'                => '隱私權聲明',
    // 必填
    'require_username'               => '請輸入管理帳號',
    'require_password'               => '請輸入管理密碼',
    'require_rpassword'              => '請輸入確認管理密碼',
    'require_idno'                   => '請輸入身份證字號',
    'require_unino'                  => '請輸入統一編號',
    'require_name'                   => '請輸入姓名',
    'require_en_name'                => '請輸入英文姓名',
    'require_birth_year'             => '請選擇出生日期 年',
    'require_birth_month'            => '請選擇出生日期 月',
    'require_birth_day'              => '請選擇出生日期 日',
    'require_id_card_year'           => '請選擇發證日期 年',
    'require_id_card_month'          => '請選擇發證日期 月',
    'require_id_card_day'            => '請選擇發證日期 日',
    'require_id_card_place'          => '請選擇發證地點',
    'require_mobile'                 => '請輸入行動電話',
    'require_email'                  => '請輸入電子郵件',
    'require_enterprise_fullname'    => '請輸入企業名稱',
    'require_enterprise_tel'         => '請輸入公司電話',
    'require_enterprise_name'        => '請輸入管理者姓名',
    'require_enterprise_en_name'     => '請輸入管理者英文姓名',
    'require_enterprise_email'       => '請輸入管理者電子郵件',
    'require_enterprise_mobile'      => '請輸入管理者行動電話',
    'require_checked_service'        => '請閱讀 {service} 並勾選',
    // Merchant
    'require_merchant_name'          => '請輸入商店名稱',
    'require_merchant_en_name'       => '請輸入商店英文名稱',
    'require_merchant_email'         => '請輸入客服信箱',
    'require_merchant_tel'           => '請輸入商店電話',
    'require_merchant_city'          => '請選擇縣市',
    'require_merchant_county'        => '請選擇鄉鎮市區',
    'require_merchant_zipcode'       => '請選擇縣市、鄉鎮市區',
    'require_merchant_address'       => '請輸入商店地址',
    'require_merchant_intro'         => '請輸入商店簡介',
    'require_merchant_url'           => '請輸入商店網址',
    'require_merchant_bank'          => '請選擇商店金融機構代碼',
    'require_merchant_sub_bank'      => '請輸入商店金融機構分行代碼',
    'require_merchant_bank_account'  => '請輸入商店金融機構帳戶',
    'require_merchant_type'          => '請選擇商店類型',
    'require_merchant_business_type' => '請選擇商店商品類型',
    'require_filters'                => '請選擇或輸入篩選規則',
    'require_refund_amount'          => '請輸入退款金額',
    'require_id_card_place'          => '請選擇身份證發(換)證縣市',
    'require_id_card_date'           => '請選擇身份證發(換)證日期',
    'require_merchant_en_name'       => '請輸入商店英文名稱',
    'require_national_en'            => '請輸入登記營業國家',
    'require_city_en'                => '請輸入登記營業城市',
    'require_merchant_type'          => '請選擇販售商品類型',
    'require_business_type'          => '請選擇商品類別',
    'require_bank_code'              => '請選擇銀行代碼',
    'require_sub_bank_code'          => '請輸入分行代碼',
    'require_bank_account'           => '請輸入銀行帳號',
    'minlength'                      => '最少需要輸入{num}個字元',
    'maxlength'                      => '最多只能輸入{num}個字元',
    'minlength_numeric'              => '最少需要輸入{num}個數字',
    'maxlength_numeric'              => '最多只能輸入{num}個數字',
    'equal_to_password'              => '確認密碼需與密碼相同',
    // 格式
    'username_format'                => '請確認帳號格式',
    'en_name_format'                 => '請確認英文名字格式',
    'email_format'                   => '請確認電子郵件格式',
    'tel_format'                     => '請確認電話格式',
    'mobile_format'                  => '請確認行動電話格式',
    'tel_format'                     => '請確認電話格式',
    'idno_format'                    => '身份證字號格式錯誤',
    'url_format'                     => '請確認網址格式',
    'unino_exist'                    => '統一編號已被使用',
    'idno_exist'                     => '身份證字號已被使用',
    'username_exist'                 => '管理帳號已存在',
    'alpha_dash'                     => '只能輸入英數"_"',
    'alpha_numeric_spaces'           => '只能輸入英數"_" " "',
    'id_card_date_format'            => '請確認日期格式',
    // transaction
    'refund_amount_format'           => '退款金額格式錯誤',
    'refund_amount_error'            => '退款金額錯誤',
    'date_more_than_today'           => '大於今天日期',
    // operator
    "operator_merchant_chooice"      => "請選擇管理商店",
    "require_operator_cpassword"     => "請輸入原本密碼",
    "require_operator_password"      => "請輸入密碼",
    "require_operator_rpassword"     => "請再輸入一次密碼",
    // merchant
    "merchant_name_format"           => "請確認商店名稱格式正確",
    "merchant_en_name_format"        => "請確認商店英文名稱格式正確",
    "merchant_key_format"            => "商店加密 key 格式不正確，請重新產生",
    "merchant_iv_format"             => "商店加密 iv 格式不正確，請重新產生",
    // terminal
    "require_merchant_selected"      => "請選擇商店",
    "require_edc_quantity"           => "請輸入 EDC 數量",
    "quantity_format"                => "請確認數量格式",
    "require_service_selected"       => "請選擇所要申請的服務",
);

/**
 * 登入
 */
$lang['login'] = array(
    'lock_login'             => '登入錯誤次數過多請等待 {seconds} 秒!',
    'personal_login_error'   => '帳號或密碼錯誤',
    'enterprise_login_error' => '統一編號或帳號或密碼錯誤',
    'check_code_error'       => '驗證碼錯誤',
);

/**
 * 註冊
 */
$lang['register_lang'] = array(
    // 欄位
    'admin'                                       => '管理者',
    'exist'                                       => '存在',
    'format_error'                                => '格式錯誤',
    'en_name_format'                              => '請確認英文名字格式',
    'alpha_dash'                                  => '只能輸入英數"_"',
    'alpha_numeric_spaces'                        => '只能輸入英數"_" " "',
    'username'                                    => '管理帳號',
    'password'                                    => '管理密碼',
    'rpassword'                                   => '確認管理密碼',
    'name'                                        => '姓名',
    'en_name'                                     => '英文姓名',
    'email'                                       => '電子郵件',
    'mobile'                                      => '行動電話',
    'fullname'                                    => '企業名稱',
    'unino'                                       => '統一編號',
    'idno'                                        => '身份證字號',
    'tel'                                         => '公司電話',
    'birth'                                       => '生日',
    'birth_year'                                  => '生日-年',
    'birth_month'                                 => '生日-月',
    'birth_day'                                   => '生日-日',
    'id_card_date'                                => '發證日期',
    'id_card_year'                                => '發證日期-年',
    'id_card_month'                               => '發證日期-月',
    'id_card_day'                                 => '發證日期-日',
    'id_card_place'                               => '發證地點',
    'date_more_than_today'                        => '大於今天日期',
    // Merchant
    'merchant_name'                               => '商店名稱',
    'merchant_en_name'                            => '商店英文名稱',
    'merchant_url'                                => '商店網址',
    'merchant_email'                              => '客服信箱',
    'merchant_tel'                                => '商店電話',
    'national_en'                                 => '登記營業國家',
    'city_en'                                     => '登記營業城市',
    'merchant_type'                               => '販售商品類型',
    'business_type'                               => '商品類別',
    'bank_code'                                   => '銀行代碼',
    'sub_bank_code'                               => '分行代碼',
    'bank_account'                                => '銀行帳號',
    'city'                                        => '縣市',
    'zipcode'                                     => '郵遞區號',
    'address'                                     => '地址',
    'intro'                                       => '商店介紹',
    'register_fail'                               => '註冊失敗',
    'personal_register'                           => '個人會員註冊',
    'personal_register_finish_message'            => '<p>您已完成個人會員註冊</p>',
    'enterprise_register'                         => '企業會員註冊',
    'enterprise_register_finish_message'          => '<p>您已完成企業註冊</p>',
    'into_system'                                 => '進入系統',
    // OTP
    'otp_error'                                   => 'OTP 錯誤',
    'otp_fail'                                    => 'OTP 失敗',
    'otp_verify_fail'                             => 'OTP認證失敗',
    'otp_fail_otp_data_message'                   => '<p>OTP認證失敗，OTP DATA錯誤</p>',
    'otp_fail_no_otp_data_message'                => '<p>OTP認證錯誤，無OTP DATA</p>',
    'otp_verify_error_limit_message'              => '<p>OTP認證失敗，失敗次數過多<br>請重新註冊</p>',
    'back_register'                               => '返回註冊',
    'otp_verify_fail'                             => '驗證失敗，錯誤次數過多請重新註冊驗證',
    'otp_code_error'                              => '驗證碼錯誤',
    'otp_not_apply'                               => '無驗證資料',
    'otp_code_not_input'                          => '未填驗證碼',
    'otp_timeout'                                 => 'OTP認證失敗，超過指定時間',
    'otp_sms_content'                             => '您的手機驗證碼：{otp_code}，請輸入到驗證碼欄位完成驗證。',
    'otp_different_mobile'                        => '手機號碼不同',
    'otp_mobile_format'                           => '請確認手機號碼格試',
    'otp_require_mobile'                          => '請輸入手機號碼',
    'otp_resend_limit'                            => '重發次數超過上限',
    // 信件
    'email_personal_subject'                      => '威力付WeCanPay帳號認證通知信',
    'email_enterprise_subject'                    => '威力付WeCanPay企業會員註冊完成通知信',
    // email verify
    'email_verify'                                => '電子信箱驗證',
    'email_verify_urldata_error_message'          => '<p>請確認驗證碼是否正確</p>',
    'email_verify_success_message'                => '<p>完成電子信箱驗證</p>',
    'email_verify_timeount_message'               => '<p>時間已過期</p><p>請重新申請，謝謝</p>',
    'email_verify_checkcode_error_message'        => '<p>驗證碼錯誤</p><p>請重新申請，謝謝</p>',
    'email_verify_data_error_message'             => '<p>請確認資料是否正確</p>',
    // 商店
    'merchant_create'                             => '商店建立',
    'merchant_create_timeout'                     => '<p>註冊時間過長，請重新註冊</p>',
    'merchant_no_data_message'                    => '<p>商店建立錯誤，無MERCHANT DATA</p>',
    'merchant_create_merchant_data_error_message' => '<p>商店建立錯誤，請確認MERCHANT DATA</p>',

);

/**
 * 忘記密碼
 */
$lang['forget_lang'] = array(
    'personal_forget_error'            => '請確認帳號或Email是否正確',
    'enterprise_forget_error'          => '請確認統一編號或帳號是否正確',
    'check_input_data'                 => '請確認是否有輸入資料',
    'sendmail_title'                   => '忘記密碼 - 重寄確認信',
    'sendmail_caption'                 => '重寄確認信',
    'sendmail_message'                 => '<p>己寄出密碼驗證信至</p><p>{email}</p><p>請您確認，謝謝</p>',
    'resetpwd_not_same'                => '請確認新密碼與確認新密碼相同',
    'resetpwd_success'                 => '重設密碼完成',
    'resetpwd_success_message'         => '<p>您的管理密碼己重設，下次登入時請使用新密碼登入。</p>',
    'resetpwd_timeout_message'         => '<p>時間已過期</p><p>請重新申請，謝謝</p>',
    'resetpwd_data_error_message'      => '<p>請確認資料是否正確</p>',
    'resetpwd_checkcode_error_message' => '<p>請確認驗證碼是否正確</p>',
    'email_subject'                    => '威力付忘記密碼驗證通知信',
);
