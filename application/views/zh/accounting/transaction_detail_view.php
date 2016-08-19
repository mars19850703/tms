<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">交易詳細資訊</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="transaction" class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed flip-content">
                                <tbody>
                                    <tr class="alert-info" style="background-color:#e0ebf9;">
                                        <td colspan="6">訂單資訊</td>
                                    </tr>
                                    <tr>
                                        <td> 威肯處理序號 </td>
                                        <td> 端末代碼 </td>
                                        <td> 支付方式 </td>
                                        <td> 狀態 </td>
                                        <td> 收單機構回傳狀態 </td>
                                        <td> 收單機構回傳訊息 </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $auth["transaction_no"]; ?></td>
                                        <td><?php echo $auth["terminal_code"]; ?></td>
                                        <td><?php echo $auth["supplier_name"] . "-" . $auth["product_name"] . "-" . $auth["action_name"] . "-" . $auth["option_name"]; ?></td>
                                        <td>
                                            <?php
                                                if ($auth["refund_status"]) {
                                                    echo constant("Constant::AccountingTransactionRefundStatus" . $auth["refund_status"]);
                                                } elseif ($auth["request_status"]) {
                                                    echo constant("Constant::AccountingTransactionRequestStatus" . $auth["request_status"]);
                                                } elseif ($auth["cancel_status"]) {
                                                    echo constant("Constant::AccountingTransactionCancelStatus" . $auth["cancel_status"]);
                                                } elseif ($auth["auth_status"]) {
                                                    echo constant("Constant::AccountingTransactionAuthStatus" . $auth["auth_status"]);
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $auth["response_code"]; ?></td>
                                        <td><?php echo $auth["response_msg"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td> 商店代號 </td>
                                        <td> 商店訂單編號 </td>
                                        <td> 金額 </td>
                                        <td> 交易日期 </td>
                                        <td> 收單機構 </td>
                                        <td> 交易 IP </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $auth["merchant_id"]; ?></td>
                                        <td><?php echo $auth["order_id"]; ?></td>
                                        <td><?php echo $auth["amount"]; ?></td>
                                        <td><?php echo $auth["create_time"]; ?></td>
                                        <td><?php echo $auth["auth_bank"]; ?></td>
                                        <td><?php echo $auth["ip"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>商品說明</td>
                                        <td colspan="5"><?php echo $auth["product_desc"]; ?></td>
                                    </tr>
                                    <?php if(!empty($cancel)): ?>
                                        <tr class="alert-danger" style="background-color:#fbe1e3;">
                                            <td colspan="6">取消授權記錄</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> 取消授權時間 </td>
                                            <td colspan="2"> 金額 </td>
                                            <td colspan="1"> 結果 </td>
                                            <td colspan="1"> ip </td>
                                        </tr>
                                        <?php foreach($cancel as $can): ?>
                                            <tr>
                                                <td colspan="2"> <?php echo $can["create_time"]; ?> </td>
                                                <td colspan="2"> <?php echo $can["amount"]; ?> </td>
                                                <td colspan="1"> <?php echo $can["response_msg"]; ?> </td>
                                                <td colspan="1"> <?php echo $can["ip"]; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if(!empty($request)): ?>
                                        <tr class="alert-success" style="background-color:#abe7ed;">
                                            <td colspan="6">請款記錄</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> 請款時間 </td>
                                            <td colspan="2"> 金額 </td>
                                            <td colspan="1"> 結果 </td>
                                            <td colspan="1"> ip </td>
                                        </tr>
                                        <?php foreach($request as $req): ?>
                                            <tr>
                                                <td colspan="2"> <?php echo $req["create_time"]; ?> </td>
                                                <td colspan="2"> <?php echo $req["amount"]; ?> </td>
                                                <td colspan="1"> <?php echo $req["response_msg"]; ?> </td>
                                                <td colspan="1"> <?php echo $req["ip"]; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if(!empty($refund)): ?>
                                        <tr class="alert-warning" style="background-color:#f9e491;">
                                            <td colspan="6">退款記錄</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> 退款時間 </td>
                                            <td colspan="2"> 金額 </td>
                                            <td colspan="1"> 結果 </td>
                                            <td colspan="1"> ip </td>
                                        </tr>
                                        <?php foreach($refund as $ref): ?>
                                            <tr>
                                                <td colspan="2"> <?php echo $ref["create_time"]; ?> </td>
                                                <td colspan="2"> <?php echo $ref["amount"]; ?> </td>
                                                <td colspan="1"> <?php echo $ref["response_msg"]; ?> </td>
                                                <td colspan="1"> <?php echo $ref["ip"]; ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($auth['auth_status'] === '1' && $auth['request_status'] === '1'): ?>
                            <hr>
                            <div class="pull-left">
                                <div class="form-group">
                                    <div class="col-md-4" style="padding-left:0px;">
                                        <div class="input-group">
                                            <input class="form-control refund_amount" type="text" name="amount" value="" placeholder="請輸入退款金額" data-auth="<?php echo $auth['amount']; ?>" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning action_btn" data-action="refund" data-transaction="<?php echo $auth['transaction_no']; ?>">
                                                    <i class="fa fa-arrow-left fa-fw"></i> 退款
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>