<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">申請 EDC 資料</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL -->
                        <div class="tab-pane active form">
                            <form id="data-form" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <select class="form-control input-inline input-medium" name="merchant_id">
                                                    <?php foreach($merchants as $merchant): ?>
                                                        <option value="<?php echo $merchant["merchant_id"]; ?>" <?php echo (!is_null($apply["merchant_id"]) ? ($apply["merchant_id"] === $merchant["merchant_id"] ? "selected='selected'":""):""); ?>><?php echo $merchant["merchant_name"]; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">終端機數量：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"> 數量 </span>
                                                <input class="form-control input-inline input-medium" type="text" name="edc_quantity" value="<?php echo (!is_null($apply["edc_quantity"]) ? $apply["edc_quantity"]:"0"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">服務：</label>
                                        <div class="col-md-10" style="padding:10px;">
                                            <!--
                                            <div>
                                                <button type="button" class="btn btn-primary" onclick="$('#service_tree').jstree('check_all');">全選</button>
                                                <button type="button" class="btn btn-warning" onclick="$('#service_tree').jstree('uncheck_all');">取消全選</button>
                                            </div>
                                            <div id="service_tree" style="margin-top:20px;">
                                                <ul>
                                                    <?php foreach($services as $supplier): ?>
                                                        <li id="<?php echo $supplier["idx"];?>" data-jstree='{"opened":true}'>
                                                            <?php echo $supplier["name"]; ?>
                                                            <?php if(!empty($supplier["child"])): ?>
                                                                <ul>
                                                                    <?php foreach($supplier["child"] as $product): ?>
                                                                        <li id="<?php echo $product["idx"];?>" data-jstree='{"opened":true}'>
                                                                            <?php echo $product["name"]; ?>
                                                                            <?php if(!empty($product["child"])): ?>
                                                                                <ul>
                                                                                    <?php foreach($product["child"] as $action): ?>
                                                                                        <li id="<?php echo $action["idx"];?>" data-jstree='{"opened":true}'>
                                                                                            <?php echo $action["name"]; ?>
                                                                                            <?php if(!empty($action["child"])): ?>
                                                                                                <ul>
                                                                                                    <?php foreach($action["child"] as $option): ?>
                                                                                                        <li id="<?php echo $option["idx"];?>" data-jstree='{"opened":true}' data-value="<?php echo $option["name"]; ?>">
                                                                                                            <?php echo $option["name"]; ?>
                                                                                                        </li>
                                                                                                    <?php endforeach; ?>
                                                                                                </ul>
                                                                                            <?php endif; ?>
                                                                                        </li>
                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            -->
                                            <?php foreach($productCategory["category"] as $categoryIdx => $category): ?>
                                                <!-- BEGIN Portlet PORTLET-->
                                                <div class="portlet light" style="margin-bottom:0px;padding-bottom:0px;">
                                                    <div class="portlet-title" style="margin-bottom:0px;">
                                                        <div class="caption">
                                                            <i class="icon-puzzle font-red-flamingo"></i>
                                                            <span class="caption-subject bold font-red-flamingo uppercase"> <?php echo $category; ?> </span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="" class="collapse"></a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-scrollable table-scrollable-borderless" style="margin-top:0px;">
                                                            <table class="table table-hover table-light">
                                                                <tbody>
                                                                    <?php foreach($services[$categoryIdx] as $service): ?>
                                                                        <tr>
                                                                            <td> <label><input type="checkbox" name="services[]" value="<?php echo $service["service"]; ?>" <?php echo (in_array($service["service"], $applyServices) ? "checked":""); ?> /> <?php echo $service["name"]; ?> </label></td>
                                                                            <td> <?php echo $service["service"]; ?> </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END Portlet PORTLET-->
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">申請備註：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <textarea class="form-control input-inline input-xlarge" name="apply_memo" style="height:150px;"><?php echo (!is_null($apply) ? $apply["apply_memo"]:""); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="margiv-top-10">
                                        <div class="col-md-12">
                                            <input type="hidden" name="apply_id" value="<?php echo (!is_null($apply) ? $apply["apply_id"]:"0"); ?>" />
                                            <button class="btn green" type="submit" id="data-form-btn"> 儲存 </button>
                                            <button class="btn btn-default" type="button" id="back-to-history" onclick="window.history.go(-1); return false;"> 回上一頁 </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <!-- END PERSONAL -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT