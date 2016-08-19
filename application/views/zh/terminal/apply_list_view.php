<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">申請列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-sm btn-default" href="/terminal/apply/update"><i class="fa fa-plus"></i> 填寫申請</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-actions-wrapper pull-right">
                        <form role="form" action="<?php echo "/terminal/apply/lists"; ?>" method="GET">
                            <input type="text" name="merchant_id" class="pagination-panel-input form-control input-inline input-sm" size="16" placeholder="商店編號" value="<?php echo $filters["merchant_id"]; ?>" style="margin-left:2px;">
                            <button type="submit" class="btn btn-sm blue table-group-action-submit" id="">搜尋</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($applyStatus as $statusKey => $status): ?>
                                        <li class="<?php echo ($status["status"] == $filters["status"] ? "active":""); ?>">
                                            <a href="<?php echo "/terminal/apply/lists/" . $statusKey . "/1"; ?>"> <?php echo $status["name"]; ?> </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:20px;">
                                <div class="tab-content">
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-hover" id="table_member">
                                            <thead>
                                              <tr>
                                                <th><small>申請單號</small></th>
                                                <th><small>商店編號</small></th>
                                                <th><small>申請 EDC 數量</small></th>
                                                <?php if($filters["status"] == 0): ?>
                                                    <th><small>功能</small></th>
                                                <?php endif; ?>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!is_null($applys)): ?>
                                                    <?php foreach($applys as $apply): ?>
                                                        <tr>
                                                            <td><?php echo $apply["apply_id"]; ?></td>
                                                            <td><?php echo $apply["merchant_id"]; ?></td>
                                                            <td><?php echo $apply["edc_quantity"]; ?></td>
                                                            <?php if($filters["status"] == 0): ?>
                                                                <td>
                                                                    <a href="/terminal/apply/update/<?php echo $apply["apply_id"]; ?>" class="btn btn-primary">編輯</a>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pull-right">
                                        <p id="pagination" data-type="<?php echo $type; ?>" data-page="<?php echo $page; ?>" data-total="<?php echo $totalPage; ?>"></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->
        </div>
    </div>
</div>