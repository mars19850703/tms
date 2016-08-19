<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">EDC 設定</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL -->
                        <div class="tab-pane active form">
                            <form id="data-form" class="form-horizontal form-bordered" role="form">
                                <div class="form-body">
                                    <?php foreach($app as $a): ?>
                                        <div class="portlet">
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <span class="caption-subject font-green uppercase bold"><?php echo $a['app_name']; ?></span>
                                                </div>
                                            </div>
                                            <?php foreach($terminal['edc_config'][$a['app_name']] as $name => $v): ?>
                                                <?php if(array_key_exists($name, $edc_setting_modified)): ?>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3"><?php echo (isset($edc_setting_modified[$name]) ? $edc_setting_modified[$name]['name']:$name); ?></label>
                                                        <div class="col-md-9">
                                                            <?php if(isset($edc_setting_modified[$name])): ?>
                                                                <?php if($edc_setting_modified[$name]['type'] === 'switch'): ?>
                                                                    <input type="checkbox" class="make-switch" data-size="small" name="server-<?php echo $a['app_name'] . '-' . $name; ?>" value="<?php echo $v; ?>" <?php echo ($v === '1' ? 'checked':''); ?> data-off-text="關閉" data-on-text="開啟">
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php foreach($terminal['edc_client_config']['Application'][$a['app_name']] as $name => $v): ?>
                                                <?php if(array_key_exists($name, $edc_setting_modified)): ?>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3"><?php echo (isset($edc_setting_modified[$name]) ? $edc_setting_modified[$name]['name']:$name); ?></label>
                                                        <div class="col-md-9">
                                                            <?php if(isset($edc_setting_modified[$name])): ?>
                                                                <?php if($edc_setting_modified[$name]['type'] === 'switch'): ?>
                                                                    <input type="checkbox" class="make-switch" data-size="small" name="client-<?php echo $a['app_name'] . '-' . $name; ?>" value="<?php echo $v; ?>" <?php echo ($v === '1' ? 'checked':''); ?> data-off-text="關閉" data-on-text="開啟">
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-actions">
                                    <div class="margiv-top-10">
                                        <div class="col-md-12">
                                            <input type="hidden" name="terminal_code" value="<?php echo $terminal['terminal_code']; ?>" />
                                            <input type="hidden" name="merchantId" value="<?php echo $merchant['merchant_id']; ?>" />
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