<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">助理帳號資料</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL -->
                        <div class="tab-pane active form">
                            <form id="data-form" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">助理帳號名稱：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <?php if(!empty($assistant)): ?>
                                                    <div style="line-height:32px;"><?php echo $assistant["operator_name"]; ?></div>
                                                <?php else: ?>
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" placeholder="請填入助理帳號名稱" class="form-control input-inline input-medium" name="operator_name" value="" />
                                                    <span class="help-inline font-yellow-casablanca">英數混合，長度6~20字元</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">助理帳號 Email：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type="text" placeholder="請填入助理帳號 Email" class="form-control input-inline input-medium" name="operator_email" value="<?php echo (!empty($assistant) ? $assistant["operator_email"]:""); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">管理商店：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <select id="merchant_manage" class="form-control input-inline input-medium" name="manage">
                                                    <option value="*" <?php echo (($operatorMerchant[0] === "*" ? "selected='selected'":"")); ?>>全部</option>
                                                    <option value="1" <?php echo (($operatorMerchant[0] !== "*" ? "selected='selected'":"")); ?>>自選商店</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="merchant" class="form-group" style="<?php echo (($operatorMerchant[0] !== "*" ? "":"display:none;")); ?>">
                                        <?php foreach($merchants as $merchant): ?>
                                            <div class="col-md-4">
                                                <div class="alert alert-success">
                                                    <div class="checkbox-list" style="overflow:hidden;white-space:nowrap;" title="<?php echo $merchant["merchant_name"]; ?>">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="merchant[]" value="<?php echo $merchant["merchant_id"]; ?>" <?php echo (in_array($merchant["merchant_id"], $operatorMerchant) ? "checked='checked'":""); ?> />&nbsp;<span style="color:#000000;"><?php echo $merchant["merchant_name"]; ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- BEGIN PERMISSION -->
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-green bold uppercase">助理帳號權限</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-scrollable">
                                                    <table class="table table-bordered table-hover" id="permission_table">
                                                        <thead>
                                                            <tr>
                                                                <th> 單元 </th>
                                                                <th> 目錄 </th>
                                                                <th> 功能 </th>
                                                                <th> 不可瀏覽 </th>
                                                                <th> 僅可瀏覽 </th>
                                                                <th> 可瀏覽可修改 </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($permissionMapping as $categoryName => $category): ?>
                                                                <?php $categoryFirst = true; ?>
                                                                <?php foreach($category["action"] as $controllerName => $controller): ?>
                                                                    <?php $actionFirst = true; ?>
                                                                    <?php foreach($controller["action"] as $methodName => $method): ?>
                                                                        <tr>
                                                                            <?php if($categoryFirst): ?>
                                                                                <td rowspan="<?php echo $category["rowspan"]; ?>"><?php echo $category["name"]; ?></td>
                                                                                <?php $categoryFirst = false; ?>
                                                                            <?php endif; ?>
                                                                            <?php if($actionFirst): ?>
                                                                                <td rowspan="<?php echo count($controller["action"]); ?>"><?php echo $controller["name"]; ?></td>
                                                                                <?php $actionFirst = false; ?>
                                                                            <?php endif; ?>
                                                                            <td><?php echo $method; ?></td>
                                                                            <td>
                                                                                <label>
                                                                                    <input type="radio" name="<?php echo $categoryName . "_" . $controllerName . "_" . $methodName; ?>" value="0" <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "0" ? "checked='checked'":""):""); ?> />
                                                                                </label>
                                                                            </td>
                                                                            <td>
                                                                                <label>
                                                                                    <input type="radio" name="<?php echo $categoryName . "_" . $controllerName . "_" . $methodName; ?>" value="1" <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "1" ? "checked='checked'":""):""); ?> />
                                                                                </label>
                                                                            </td>
                                                                            <td>
                                                                                <label>
                                                                                    <input type="radio" name="<?php echo $categoryName . "_" . $controllerName . "_" . $methodName; ?>" value="3" <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "3" ? "checked='checked'":""):""); ?> />
                                                                                </label>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PERMISSION -->
                                </div>
                                <div class="form-actions">
                                    <div class="margiv-top-10">
                                        <div class="col-md-12">
                                            <input type="hidden" name="operator_idx" value="<?php echo (!empty($assistant) ? $assistant["idx"]:"0"); ?>" />
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