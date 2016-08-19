<table border="1" cellspacing="0" cellpadding="15">
    <tbody><tr>
        <td align="center" width="700"><table width="650" border="0" cellspacing="5" cellpadding="5">
                <tbody><tr>
                    <td align="center"><h1><span><font style="font-family:微軟正黑體">威力付WeCanPay企業會員註冊完成通知信</font></span></h1></td>
                </tr>
                <tr>
                    <td><font style="font-family:微軟正黑體">親愛的 <?=$member_company_name?> 會員，您好：</font></td>
                </tr>
                <tr>
                    <td align="center"><font style="font-family:微軟正黑體">您已於 <?=date("Y-m-d H:i:s")?> 註冊完成</font></td>
                </tr>
            </tbody></table>
            <table width="650" border="0" cellspacing="5" cellpadding="0">
                <tbody><tr>
                    <td align="center" bgcolor="#f39928">
                        <h3><font style="font-family:微軟正黑體">您註冊的會員資訊如下</font></h3>
                        <table width="650" border="1" cellspacing="0" cellpadding="15">
                            <tbody><tr>
                                <td width="141" height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">WeCanPay</font></td>
                                <td width="433" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><a href="<?=$domain?>" target="_blank"><?=$domain?></a></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">公司名稱</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$member_company_name?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">管理帳號</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$operator_name?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">公司電話</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$member_tel?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">管理者姓名</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$member_name?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">管理者手機</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$member_phone?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">管理者信箱</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><a href="mailto:<?=$operator_email?>" target="_blank"><?=$operator_email?></a></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">IP位址</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$this->input->ip_address()?></font></td>
                            </tr>
                        </tbody></table>

                    </td>
                </tr>
            </tbody></table>
            <table width="650" border="0" cellspacing="5" cellpadding="0">
                <tbody>
                <tr>
                    <td>立即登入威力付WeCanPay</td>
                </tr>
                <tr>
                    <td><div> 登入密碼於您註冊時已設定，為保護您的登入資訊安全，<wbr>請自行妥善保管。
                        <br>
                        若忘記登入密碼，請點選《 <a href="<?=$domain.'/member/forget#enterprise'?>" target="_blank">忘記密碼</a> 》。 <br></div></td>
                </tr>
                
                <tr>
                    <td align="center"><div><font style="font-family:微軟正黑體;font-size:14px;color:#f00">本電子信箱為系統自動發送通知使用，請勿直接回覆，如有任何疑問，歡迎來信!</font></div></td>
                </tr>
                <tr>
                    <td align="center"><div>
                            <span>客服專線：886-2-2358-1138<br>
                                客服信箱：<a href="mailto:cs@wecanpay.tw" target="_blank">cs@wecanpay.tw</a></span></div>
                    </td>
                </tr>
            </tbody></table></td>
    </tr>
</tbody></table>