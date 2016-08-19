<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-users"></i>
                        <span class="caption-subject bold uppercase">助理帳號列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-sm btn-default" href="/member/operator/update"><i class="icon-user-follow"></i> 新增助理帳號</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--
                    <div class="table-actions-wrapper pull-right">
                        <form role="form" action="<?php echo "administrator/orders"; ?>" method="GET">
                            <div class="checkbox-list pull-left" style="line-height: 2;margin-right: 12px;">
                                <label class="checkbox-inline input-inline">
                                    <input type="checkbox" name="noPager" value="1"> 不分頁
                                </label>
                            </div>
                            <div class="input-group input-large date-picker input-daterange  pull-left" data-date="2015-10-01" data-date-format="yyyy-mm">
                                <span class="input-group-addon"> 付款日期 </span>
                                <input type="text" class="form-control input-sm form_datetime" size="10" name="date_start_o" value="">
                                <span class="input-group-addon"> 到 </span>
                                <input type="text" class="form-control input-sm form_datetime" size="10" name="date_end_o" value="">
                            </div>
                            <select name="affiliate_code" class="pagination-panel-input form-control input-inline input-sm" style="margin-left:5px;">
                                <option value="">選擇合作廠商</option>
                            </select>
                            <input type="text" name="keyword" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="客戶資訊" value="" style="margin-left:5px;">
                            <input type="text" name="order_sn" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="訂單編號" value="" style="margin-left:2px;">
                            <button type="submit" class="btn btn-sm blue table-group-action-submit" id="">搜尋</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    -->
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover" id="table_member">
                            <thead>
                              <tr>
                                <th><small>助理帳號名稱</small></th>
                                <th><small>助理帳號 Email</small></th>
                                <th><small>狀態</small></th>
                                <th><small>設定</small></th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php if(!is_null($operators)): ?>
                                    <?php foreach($operators as $operator): ?>
                                        <tr>
                                            <td><?php echo $operator["operator_name"]; ?></td>
                                            <td><?php echo $operator["operator_email"]; ?></td>
                                            <td><?php echo constant("Constant::MemberOperatorStatus" . $operator["operator_status"]); ?></td>
                                            <td>
                                                <?php if ($operator["operator_status"] === "0"): ?>
                                                    <a href="/member/operator/update/<?php echo $operator["idx"]; ?>" class="btn btn-primary">編輯權限</a>
                                                    <a href="javascript:;" target="_blank" class="btn btn-success operator_btn" data-sn="<?php echo $operator["idx"]; ?>">啟用</a>
                                                <?php elseif ($operator["operator_status"] === "1"): ?>
                                                    <a href="/member/operator/update/<?php echo $operator["idx"]; ?>" class="btn btn-primary">編輯權限</a>
                                                    <a href="javascript:;" target="_blank" class="btn btn-warning operator_btn" data-sn="<?php echo $operator["idx"]; ?>">暫停使用</a>
                                                <?php elseif ($operator["operator_status"] === "9"): ?>
                                                    <?php echo nl2br($operator["operator_memo"]); ?>
                                                <?php endif; ?>
                                                <!-- <a href="javascript:;" class="btn red-sunglo">停止使用</a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!---
                    <div class="pull-left">
                        <a href="javascript:;" target="_blank" class="btn red-sunglo" id="btn_order_print">匯出撿貨單</a>
                        <a href="javascript:;" target="_blank" class="btn green-jungle" id="btn_order_csv">下載寄件資料</a>
                    </div>
                    -->
                    <div class="clearfix"></div>
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>