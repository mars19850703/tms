<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">授權交易詳細資訊</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="transaction" class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed flip-content">
                                <tbody>
                                    <tr>
                                        <td> 威肯處理序號 <br/> 商店訂單編號 </td>
                                        <td> 商店代號 </td>
                                        <td> 支付方式 </td>
                                        <td> 金額 </td>
                                        <td> 狀態 </td>
                                        <td> 收單機構 </td>
                                        <td> 交易 IP </td>
                                        <td> 訂單總金額 </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $auth["transaction_no"]; ?><br/><?php echo $auth["order_id"]; ?></td>
                                        <td><?php echo $auth["merchant_id"]; ?></td>
                                        <td><?php echo $auth["supplier_name"] . "-" . $auth["product_name"] . "-" . $auth["action_name"] . "-" . $auth["option_name"]; ?></td>
                                        <td><?php echo $auth["amount"]; ?></td>
                                        <td>
                                            <?php
                                                if ($auth["cancel_status"]) {
                                                    echo constant("Constant::StoreTransactionCancelStatus" . $auth["cancel_status"]);
                                                } elseif ($auth["auth_status"]) {
                                                    echo constant("Constant::StoreTransactionAuthStatus" . $auth["auth_status"]);
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $auth["auth_bank"]; ?></td>
                                        <td><?php echo $auth["ip"]; ?></td>
                                        <td><?php echo $auth["amount"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>交易日期</td>
                                        <td>交易截止日</td>
                                        <td colspan="3">支付日期</td>
                                        <td colspan="3">撥款日</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $auth["create_time"]; ?></td>
                                        <td></td>
                                        <td colspan="3"></td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>商品說明</td>
                                        <td colspan="7"><?php echo $auth["product_desc"]; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>