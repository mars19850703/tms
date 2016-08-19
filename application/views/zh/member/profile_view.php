<style type="text/css">
    .textLeft{text-align:left !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">個人帳號資訊</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#profile_data" data-toggle="tab">個人資料</a>
                                </li>
                                <li class="">
                                    <a href="#modify_password" data-toggle="tab">修改密碼</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="profile_data">
                                    <form class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="control-label col-md-3">名稱：</div>
                                                <div class="control-label col-md-9 textLeft">
                                                    <?php echo $operator["operator_name"]; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="control-label col-md-3">Email：</div>
                                                <div class="control-label col-md-9 textLeft">
                                                    <?php echo $operator["operator_email"]; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="portlet">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase" style="font-size:15px;">權限</span>
                                                </div>
                                            </div>
                                        </div>
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
                                                                    <?php if($operator["operator_type"] !== "9"): ?>
                                                                        <td>
                                                                            <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "0" ? "<i class='fa fa-check'></i>":""):""); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "1" ? "<i class='fa fa-check'></i>":""):""); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo (isset($permission[$categoryName][$controllerName][$methodName]) ? ($permission[$categoryName][$controllerName][$methodName] === "3" ? "<i class='fa fa-check'></i>":""):""); ?>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <i class='fa fa-check'></i>
                                                                        </td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->                                
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="modify_password">
                                    <form id="pwd-form" method="post">
                                        <div class="form-group">
                                            <label class="control-label">現在密碼</label>
                                            <input type="password" name="current_password" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">新密碼</label>
                                            <input type="password" name="password" class="form-control"> </div>
                                        <div class="form-group">
                                            <label class="control-label">確認新密碼</label>
                                            <input type="password" name="rpassword" class="form-control"> </div>
                                        <div class="margin-top-10">
                                            <button type="submit" id='data-form-btn' class="btn green"> 修改密碼 </button>
                                            <a href="javascript:;" class="btn default"> 取消 </a>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>