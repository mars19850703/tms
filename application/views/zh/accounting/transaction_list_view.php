<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-briefcase"></i>
                        <span class="caption-subject bold uppercase">交易查詢列表</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-actions-wrapper pull-right">
                        <form id="filter-form" role="form">
                            <select class="pagination-panel-input form-control input-inline input-sm pull-left" name="type">
                                <?php foreach($transactionStatus as $statusKey => $status): ?>
                                    <option value="<?php echo $statusKey; ?>" <?php echo ($filters["type"] === $statusKey ? "selected='selected'":""); ?>><?php echo $status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        	<div class="input-group input-large date-picker input-daterange pull-left" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd" style="margin-left:5px;">
                                <span class="input-group-addon"> 交易日期 </span>
                                <input type="text" class="form-control input-sm" name="start" value="<?php echo $filters["start"]; ?>" readonly="true">
                                <span class="input-group-addon"> 到 </span>
                                <input type="text" class="form-control input-sm" name="end" value="<?php echo $filters["end"]; ?>" readonly="true">
    						</div>
                            <select class="pagination-panel-input form-control input-inline input-sm pull-left" name="merchant_id" style="margin-left:5px;">
                                <option value="">請選擇商店</option>
                                <?php foreach($merchants as $merchant): ?>
                                    <option value="<?php echo $merchant["merchant_id"]; ?>" <?php echo ($filters["merchant_id"] === $merchant["merchant_id"] ? "selected='selected'":""); ?>><?php echo $merchant["merchant_name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="terminal_id" class="pagination-panel-input form-control input-inline input-sm pull-left" size="16" placeholder="端末代碼" value="<?php echo $filters["terminal_id"]; ?>" style="margin-left:5px;">
                            <button type="submit" class="btn btn-sm blue table-group-action-submit" id="filter_btn" style="margin-left:5px;">搜尋</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <!-- <div class="col-md-2 col-sm-2 col-xs-2">
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($transactionStatus as $statusKey => $status): ?>
                                        <li class="<?php echo ($statusKey == $filters["type"] ? "active":""); ?>" data-status="">
                                            <a href="<?php echo "/accounting/transaction/lists/" . $statusKey; ?>"> <?php echo $status; ?> </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div> -->
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="transaction" class="tab-content">
                                    
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