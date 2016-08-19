<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">Edc 列表</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-actions-wrapper pull-right">
                        <form role="form" action="<?php echo "/terminal/manage/lists"; ?>" method="GET">
                        <input type="text" name="merchant_id" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="商店代碼" value="<?php echo $filters["merchant_id"]; ?>" style="margin-left:2px;">
                            <input type="text" name="terminal_id" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="端末代碼" value="<?php echo $filters["terminal_id"]; ?>" style="margin-left:2px;">
                            <button type="submit" class="btn btn-sm blue table-group-action-submit" id="">搜尋</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover" id="table_member">
                                <thead>
                                  <tr>
                                    <th><small>商店代碼</small></th>
                                    <th><small>商店名稱</small></th>
                                    <th><small>端末代碼</small></th>
                                    <th><small>Edc 狀態</small></th>
                                    <th><small>詳細資訊</small></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php if(!is_null($terminals)): ?>
                                        <?php foreach($terminals as $terminal): ?>
                                            <tr>
                                                <td><?php echo $terminal["merchant_id"]; ?></td>
                                                <td><?php echo $terminal["merchant_name"]; ?></td>
                                                <td><?php echo $terminal["terminal_code"]; ?></td>
                                                <td><?php echo constant("Constant::TerminalStatus" . $terminal["terminal_status"]); ?></td>
                                                <td>
                                                    <a href="/terminal/manage/update/<?php echo $terminal['idx']; ?>" class="btn dark">設定</a>
                                                    <a href="/accounting/transaction/lists?type=auth&terminal_id=<?php echo $terminal["terminal_code"]; ?>" class="btn btn-info">交易授權</a>
                                                    <a href="/accounting/transaction/lists?type=cancel&terminal_id=<?php echo $terminal["terminal_code"]; ?>" class="btn btn-warning">取消交易授權</a>
                                                    <a href="/accounting/transaction/lists?type=request&terminal_id=<?php echo $terminal["terminal_code"]; ?>" class="btn btn-success">交易請款</a>
                                                    <a href="/accounting/transaction/lists?type=refund&terminal_id=<?php echo $terminal["terminal_code"]; ?>" class="btn btn-danger">交易退款</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="pull-right">
                            <p id="pagination" data-page="<?php echo $page; ?>" data-total="<?php echo $totalPage; ?>"></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>