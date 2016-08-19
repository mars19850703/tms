<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">商店列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-sm btn-default" href="/store/merchant/update"><i class="fa fa-plus"></i> 新增商店</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-actions-wrapper pull-right">
                        <form role="form" action="<?php echo "/store/merchant/lists"; ?>" method="GET">
                        	<!--
                            <input type="text" name="keyword" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="商店關鍵字" value="<?php echo $filters["keyword"]; ?>" style="margin-left:5px;">
                            -->
                            <input type="text" name="merchant" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="商店編號" value="<?php echo $filters["merchant"]; ?>" style="margin-left:2px;">
                            <button type="submit" class="btn btn-sm blue table-group-action-submit" id="">搜尋</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover" id="table_member">
                            <thead>
                              <tr>
                                <th><small>商店名稱</small></th>
                                <th><small>商店編號</small></th>
                                <th><small>商店電話</small></th>
                                <th><small>商店客服 Email</small></th>
                                <th><small>狀態</small></th>
                                <!--
                                <th><small>商店 key</small></th>
                                <th><small>商店 iv</small></th>
                                -->
                                <th><small>設定</small></th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php if(!is_null($merchants)): ?>
                                    <?php foreach($merchants as $merchant): ?>
                                        <tr>
                                            <td>
                                            	<a href="<?php echo $merchant["merchant_url"]; ?>" target="_blank">
                                            		<?php echo $merchant["merchant_name"]; ?>&nbsp;<i class="fa fa-external-link"></i>
                                        		</a>
                                    		</td>
                                            <td><?php echo $merchant["merchant_id"]; ?></td>
                                            <td><?php echo $merchant["merchant_tel"]; ?></td>
                                            <td><?php echo $merchant["merchant_service_email"]; ?></td>
                                            <td><?php echo constant("Constant::StoreMerchantStatus" . $merchant["merchant_status"]); ?></td>
                                            <!--
                                            <td><?php echo $merchant["merchant_key"]; ?></td>
                                            <td><?php echo $merchant["merchant_iv"]; ?></td>
                                            -->
                                            <td>
                                                <?php if ($merchant["merchant_status"] === "2"): ?>
                                                    <a href="/store/merchant/update/<?php echo $merchant["merchant_id"]; ?>" class="btn btn-primary">編輯</a>
                                                    <a href="javascript:;" target="_blank" class="btn btn-warning merchant_btn" data-sn="<?php echo $merchant["merchant_id"]; ?>">暫停使用</a>
                                                <?php elseif ($merchant["merchant_status"] === "7"): ?>
                                                    <a href="/store/merchant/update/<?php echo $merchant["merchant_id"]; ?>" class="btn btn-primary">編輯</a>
                                                    <a href="javascript:;" target="_blank" class="btn btn-success merchant_btn" data-sn="<?php echo $merchant["merchant_id"]; ?>">啟用</a>
                                                <?php elseif ($merchant["merchant_status"] === "8" || $merchant["merchant_status"] === "9"): ?>
                                                    <?php echo nl2br($merchant["merchant_memo"]); ?>
                                                <?php endif; ?>
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
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>