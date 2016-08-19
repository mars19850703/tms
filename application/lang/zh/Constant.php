<?php

class Constant
{
    // System Setting
    const CustomerServiceEmail = 'mars.lin.0703@gmail.com';
    const CustomerServiceName  = '客服';

    // System Message
    const PermissionDeined         = '沒有權限進入';
    const PermissionDeinedToUpdate = '沒有編輯權限';
    const InsertDataSuccess        = '已新增資料';
    const UpdateDataSuccess        = '已更新資料';
    const DataError                = '資料錯誤';
    const DatabaseError            = '資料庫發生問題，請聯絡客服';
    const EmailFormateError        = '電子郵件格式錯誤';
    const TelFormateError          = '電話格式錯誤';
    const AccountFormateError      = '帳號格式錯誤';
    const AddressLengthNotEnough   = '地址長度不對';
    const KeyFormatError           = '商店 key 格式錯誤';
    const IvFormatError            = '商店 iv 格式錯誤';
    const ZipcodeFormatError       = '商店郵遞區號格式錯誤';
    const CityFormatError          = '商店地址縣市格式錯誤';
    const CountyFormatError        = '商店地址鄉鎮區格式錯誤';
    const UrlFormatError           = '網址格式錯誤';
    const ToLogin                  = '請登入';
    const ToLoginAgain             = '請重新登入';

    // Valid
    const ValidNoError      = '沒有錯誤';
    const ValidErrorDefault = '%s 欄位資料錯誤';

    // Member Operator
    const MemberEnNameFormatError          = '會員英文姓名格式錯誤';
    const MemberIdCardPlaceFormatError     = '會員身份證發(換)證地點格式錯誤';
    const MemberIdCardDateMoreThenToday    = '發換證日期大於今日';
    const MemberIdCardDateFormatError      = '會員身份證發(換)證日期格式錯誤';
    const MemberMaintainTitle              = '基本資料維護';
    const MemberOperatorTitle              = '助理帳號設定';
    const MemberOperatorProfileTitle       = '個人資訊';
    const MemberOperatorPasswordError      = '密碼格式錯誤';
    const MemberOperatorCPasswordError     = '原始密碼錯誤';
    const MemberOperatorEqualPasswordError = '密碼確認錯誤';
    const MemberOperatorChangePassword     = '已更新密碼，請重新登入';
    const MemberOperatorNameExist          = '此名稱已經存在';
    const MemberOperatorQuantityOver       = '助理帳號數量已達上限';
    const MemberOperatorAccountEmail       = '會員助理帳號啟用通知';
    const MemberOperatorMerchantDataError  = '助理帳號商店資料錯誤';
    const MemberOperatorStatus0            = '暫停使用';
    const MemberOperatorStatus1            = '正常使用';
    const MemberOperatorStatus9            = '停止使用';

    // Store Merchant
    const StoreMerchantTitle                   = '商店管理';
    const StoreMerchantIDError                 = '商店編號錯誤';
    const StoreMerchantStatus0                 = '未開通';
    const StoreMerchantStatus1                 = '審核中';
    const StoreMerchantStatus2                 = '正常使用';
    const StoreMerchantStatus7                 = '暫停使用';
    const StoreMerchantStatus8                 = '停止使用';
    const StoreMerchantStatus9                 = '刪除';
    const StoreMerchantNameFormatError         = '商店名稱格式錯誤';
    const StoreMerchantEnNameFormatError       = '商店英文名稱格式錯誤';
    const StoreMerchantNationalFormatError     = '商店登記營業國家格式錯誤';
    const StoreMerchantCityFormatError         = '商店登記營業城市格式錯誤';
    const StoreMerchantBankCodeFormatError     = '商店帳戶金融機構代碼格式錯誤';
    const StoreMerchantBankNameFormatError     = '商店帳戶金融機構名稱格式錯誤';
    const StoreMerchantSubBankCodeFormatError  = '商店帳戶金融機構分行代碼格式錯誤';
    const StoreMerchantBankAccountFormatError  = '商店帳戶金融機構帳號格式錯誤';
    const StoreMerchantTypeFormatError         = '商店類型格式錯誤';
    const StoreMerchantBusinessTypeFormatError = '商店商品類型格式錯誤';

    // Store Merchant
    const StoreTransactionTitle = '銷售紀錄查詢';

    // Accounting Transation
    const AccountingTransactionTitle          = '交易紀錄查詢';
    const AccountingTransactionAuthStatus0    = '未授權';
    const AccountingTransactionAuthStatus1    = '授權成功';
    const AccountingTransactionAuthStatus2    = '授權失敗';
    const AccountingTransactionCancelStatus0  = '取消授權失敗';
    const AccountingTransactionCancelStatus1  = '取消授權成功';
    const AccountingTransactionRequestStatus0 = '請款失敗';
    const AccountingTransactionRequestStatus1 = '請款成功';
    const AccountingTransactionRequestStatus2 = '部分請款成功';
    const AccountingTransactionRefundStatus0  = '退款失敗';
    const AccountingTransactionRefundStatus1  = '退款成功';
    const AccountingTransactionRefundStatus2  = '部分退款成功';

    // Terminal
    const TerminalApplyTitle   = '終端設備申請';
    const TerminalApplyIDError = '申請單號錯誤';
    const TerminalManageTitle  = '終端設備管理';
    const EdcStatus0           = '停用';
    const EdcStatus1           = '啟用';
    const EdcStatus2           = '測試中';
    const TerminalStatus0      = '停用';
    const TerminalStatus1      = '啟用';
    const EdcTerminalCodeError = 'EDC 端末代碼錯誤';
    const EdcMerchantIdError   = 'EDC 商店代號錯誤';
}
