<div class="table-scrollable">
    <table class="table table-striped table-bordered table-hover" id="table_member">
        <thead>
          <tr>
            <!--
            <?php if($filters['type'] === 'auth'): ?>
                <th><input type="checkbox" name="checkAll"></th>
            <?php endif; ?>
            -->
            <th><small>交易序號</small></th>
            <th><small>商店訂單編號</small></th>
            <th><small>商店代號</small></th>
            <th><small>端末代碼</small></th>
            <th><small>支付方式</small></th>
            <th><small>訂單金額</small></th>
            <th><small>交易日期</small></th>
            <th><small>交易狀態</small></th>
            <th><small>功能</small></th>
          </tr>
        </thead>
        <tbody>
            <?php if(!is_null($auths)): ?>
                <?php foreach($auths as $auth): ?>
                    <tr>
                        <!--
                        <?php if(($filters['type'] === 'auth')  && !empty($auth["trade_no"])): ?>
                            <td><input type="checkbox" name="action[]" value="<?php echo $auth['transaction_no']; ?>"></td>
                        <?php elseif (($filters['type'] === 'auth') && empty($auth["trade_no"])): ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                        -->
                        <td><?php echo $auth["trade_no"]; ?></td>
                        <td><?php echo $auth["order_id"]; ?></td>
                        <td><?php echo $auth["merchant_id"]; ?></td>
                        <td><?php echo $auth["terminal_code"]; ?></td>
                        <td><?php echo $auth["supplier_name"] . "-" . $auth["product_name"] . "-" . $auth["action_name"] . "-" . $auth["option_name"]; ?></td>
                        <td style="text-align:right;"><?php echo $auth["amount"]; ?></td>
                        <td><?php echo $auth["create_time"]; ?></td>
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
                        <td>
                            <a href="<?php echo "/accounting/transaction/detail/" . $auth["transaction_no"]; ?>" class="btn btn-primary" target="_blank">詳細資訊</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="pull-left">
    <!--
    <?php if($filters['type'] === 'auth'): ?>
        <button type="button" class="btn btn-success action_btn" data-action="request">請款</button>
        <button type="button" class="btn btn-danger action_btn" data-action="cancel">取消授權</button>
    <?php elseif($filters['type'] === 'request'): ?>
        <button type="button" class="btn btn-warning action_btn" data-action="refund">退款</button>
    <?php endif; ?>
    -->
</div>
<div class="pull-right">
    <p id="pagination" data-page="<?php echo $filters["page"]; ?>" data-total="<?php echo $totalPage; ?>"></p>
</div>
<div class="clearfix"></div>