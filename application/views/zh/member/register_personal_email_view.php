<table border="1" cellspacing="0" cellpadding="15">
    <tbody><tr>
        <td align="center" width="700"><table width="650" border="0" cellspacing="5" cellpadding="5">
                <tbody><tr>
                    <td align="center"><h1><span><font style="font-family:微軟正黑體">威力付WeCanPay <span class="il"></span> 帳號認證通知信</font></span></h1></td>
                </tr>
                <tr>
                    <td><font style="font-family:微軟正黑體">親愛的 <?=$member_name?> 會員，您好：</font></td>
                </tr>
                <tr>
                  <td><font style="font-family:微軟正黑體">您於 <?=date("Y-m-d H:i:s")?> 註冊威力付WeCanPay帳號，請先認證您的E-mail，以完成註冊流程。</font></td>
                </tr>                
            </tbody></table>

            <table width="650" border="0" cellspacing="5" cellpadding="0">
                <tbody><tr>
                    <td align="center" bgcolor="#f39928">
                        <h3><font style="font-family:微軟正黑體">您註冊的會員資訊如下</font></h3>
                        <table width="650" border="1" cellspacing="0" cellpadding="15">
                            <tbody><tr>
                                <td width="141" height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><span class="il">WeCanPay</span>網址</font></td>
                                <td width="433" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><a href="<?=$domain?>" target="_blank">https://tms.<span class="il">wecanpay.com</span>.tw/</a></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">登入帳號</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$operator_name?></font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">聯絡手機</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$member_phone?> ( 已認證 )</font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">E-mail</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><a href="mailto:<?=$operator_email?>" target="_blank"><?=$operator_email?></a> (<a href="<?=$email_verify_url?>" target="_blank"> 未認證，立即前往認證 </a>)</font></td>
                            </tr>
                            <tr>
                                <td height="30" align="right" bgcolor="#FFFFFF"><font style="font-family:微軟正黑體">IP位址</font></td>
                                <td bgcolor="#FFFFFF"><font style="font-family:微軟正黑體"><?=$this->input->ip_address()?></font></td>
                            </tr>
                        </tbody></table>

                    </td>
                </tr>
            </tbody></table><table width="650" border="0" cellspacing="5" cellpadding="5">
                <tbody><tr>
                    <td width="600" height="66" style="word-break:break-all"><font style="font-family:微軟正黑體"><p>若您無法有效點擊認證連結，請於上方「<font style="color:#ea7500">未認證，立即前往認證</font>」<wbr>文字上點選滑鼠右鍵複製超連結，並貼至您的瀏覽器網址列執行。</p></font></td>
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
                            若忘記登入密碼，請點選《 <a href="<?=$domain?>/member/forget" target="_blank">忘記密碼</a> 》。 <br></div></td>
                </tr>
                
                <tr>
                    <td align="center"><div><font style="font-family:微軟正黑體;font-size:14px;color:#f00">本電子信箱為系統自動發送通知使用，請勿直接回覆，如有任何疑問，歡迎來信!</font></div></td>
                </tr>
                <tr>
                    <td align="center">                            
                            <span>客服專線：886-2-2358-1138<br>
                                客服信箱：<a href="mailto:cs@wawago.tw" target="_blank">cs@<span class="il">wecanpay</span>.com.tw</a></span></div>
                    </td>
                </tr>
            </tbody></table></td>
    </tr>
</tbody></table>