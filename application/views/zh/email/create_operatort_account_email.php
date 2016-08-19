<table border="1" cellspacing="0" cellpadding="15">
    <tbody><tr>
        <td align="center" width="700"><table width="650" border="0" cellspacing="5" cellpadding="5">
                <tbody><tr>
                    <td align="center"><h1><span><font style="font-family:微軟正黑體">會員助理帳號啟用通知</font></span></h1></td>
                </tr>
                <tr>
                    <td align="left"><font style="font-family:微軟正黑體">親愛的 <?php echo (isset($operator_name) ? $operator_name : ''); ?> 會員，您好：</font></td>
                </tr>
                <tr>
                    <td align="left"><font style="font-family:微軟正黑體">以下為 威力付 助理帳號啟用通知信</font></td>
                </tr>
                <tr>
                    <td height="100" align="left"><font style="font-family:微軟正黑體">帳號 : <?php echo (isset($operator_name) ? $operator_name : ''); ?></font></td>
                </tr>
                <tr>
                    <td height="100" align="left"><font style="font-family:微軟正黑體">密碼 : <?php echo (isset($operator_password) ? $operator_password : '') ?></font></td>
                </tr>
                <tr>
                    <td height="100" align="left"><font style="font-family:微軟正黑體">【<a href="<?php echo $login_url; ?>" target="_blank">點擊連結</a>】</font></td>
                </tr>
                <tr>
                    <td align="left"><font style="font-family:微軟正黑體">若您無法點擊連結，<wbr>請複製以下完整連結至瀏覽器網址列貼上並打開網頁進行驗證。</font></td>
                </tr>
                <tr>
                    <td align="left" style="word-break:break-all"><font style="font-family:微軟正黑體;font-size:9px"><a href="<?php echo $login_url; ?>" target="_blank"><?php echo $login_url; ?></a></font></td>
                </tr>
            </tbody></table>
            <table width="650" border="0" cellspacing="5" cellpadding="0">
                <tbody><tr>
                    <td height="100"><font style="font-family:微軟正黑體">祝 順頌商棋！</font></td>
                </tr>
                <tr>
                    <td align="center"><font style="font-family:微軟正黑體;font-size:12px">IP：<?php echo $_SERVER['REMOTE_ADDR']; ?></font></td>
                </tr>
                <tr>
                    <td align="center"><div><font style="font-family:微軟正黑體;font-size:14px;color:#f00">本電子信箱為系統自動發送通知使用，請勿直接回覆， 如有任何疑問，歡迎來信以下客服專用信箱。</font></div></td>
                </tr>
                <tr>
                    <td align="center"><div>威力付 客服中心<font style="color:#f88a12">　誠信．創新．行動．專業 </font><br>
                            <span>客服專線：886-2-2653-6000　
                                客服信箱：<a href="mailto:cs@pay2go.com" target="_blank">cs@pay2go.com</a></span></div>
                    </td>
                </tr>
            </tbody></table></td>
    </tr>
</tbody></table>