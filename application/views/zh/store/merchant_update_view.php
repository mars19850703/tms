<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">商店資料</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <!-- PERSONAL -->
                        <div class="tab-pane active form">
                            <form id="data-form" class="form-horizontal" role="form">
                                <div class="form-body">
                                    <?php if(!empty($merchant)): ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">商店編號：</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <div style="line-height:32px;"><?php echo $merchant["merchant_id"]; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">名稱：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <?php if(!empty($merchant)): ?>
                                                    <div style="line-height:32px;"><?php echo $merchant["merchant_name"]; ?></div>
                                                <?php else: ?>
                                                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                                    <input type="text" placeholder="請填入商店名稱" class="form-control input-inline input-xlarge" name="merchant_name" value="" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">英文名稱：</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <?php if(!empty($merchant)): ?>
                                                    <div style="line-height:32px;"><?php echo $merchant["merchant_en_name"]; ?></div>
                                                <?php else: ?>
                                                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                                    <input type="text" placeholder="請填入商店名稱（英文）" class="form-control input-inline input-xlarge" name="merchant_en_name" value="" />
                                                    <span class="help-inline font-yellow-casablanca">英數混合(含 空白_ )，長度1~45字元</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                    <?php if(!empty($merchant)): ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-2">商店 Key & Iv：</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                    <input type="text" class="form-control" name="merchant_key" value="<?php echo (!empty($merchant) ? $merchant["merchant_key"]:""); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"></label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                    <input type="text" class="form-control" name="merchant_iv" value="<?php echo (!empty($merchant) ? $merchant["merchant_iv"]:""); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"></label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button id="generate-key-iv-btn" class="btn btn-success" type="button">
                                                            <i class="fa fa-arrow-up fa-fw"></i>產生新的 Key & Iv
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    -->
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店電話：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant["merchant_tel"]; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input type="text" placeholder="請填入商店電話" class="form-control" name="merchant_tel" value="<?php echo (!empty($merchant) ? $merchant["merchant_tel"]:""); ?>" />
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">登記營業國家：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant['national_en']; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                    <input type="text" placeholder="請填入商店營業登記國家（英文）" class="form-control" name="national_en" value="" />
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">登記營業城市：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant['city_en']; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                                    <input type="text" placeholder="請填入商店營業登記城市（英文）" class="form-control" name="city_en" value="" />
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店地址：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo "(" . $merchant["merchant_zipcode"] . ") " . $merchant["merchant_city"] . $merchant["merchant_county"] . $merchant["merchant_address"]; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group merchant_address">
                                                    <span class="input-group-addon"> 郵遞區號 </span>
                                                    <input type="text" class="form-control zipcode" value="<?php echo (!empty($merchant) ? $merchant["merchant_zipcode"]:""); ?>" disabled>
                                                    <input type="hidden" class="form-control zipcode" name="merchant_zipcode" value="<?php echo (!empty($merchant) ? $merchant["merchant_zipcode"]:""); ?>">
                                                    <span class="input-group-addon"> 縣市 </span>
                                                    <select class="form-control city" name="merchant_city" data-city="<?php echo (!empty($merchant) ? $merchant["merchant_city"]:""); ?>">
                                                        <option value="0">請選擇縣市</option>
                                                    </select>
                                                    <span class="input-group-addon"> 鄉鎮區 </span>
                                                    <select class="form-control county" name="merchant_county" data-county="<?php echo (!empty($merchant) ? $merchant["merchant_county"]:""); ?>"></select>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(empty($merchant)): ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"></label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"> 地址 </span>
                                                    <input type="text" class="form-control" name="merchant_address" value="<?php echo (!empty($merchant) ? $merchant["merchant_address"]:""); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店客服信箱：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant['merchant_service_email']; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                    <input type="text" placeholder="請填入商店客服信箱" class="form-control" name="merchant_service_email" value="<?php echo (!empty($merchant) ? $merchant["merchant_service_email"]:""); ?>" />
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店金融機構賬戶：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant["bank_code"] . "-" . $merchant["sub_bank_code"] . "-" . $merchant["bank_account"] . ' (' . $merchant["bank_name"] . ')'; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"> 機構代碼 </span>
                                                    <select class="form-control" name="bank">
                                                        <option value="">請選擇銀行</option>
                                                        <?php foreach($bankCode as $bank): ?>
                                                            <option value="<?php echo $bank['code'] . '-' . $bank['name']; ?>"><?php echo $bank['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="input-group-addon"> 分行代碼 </span>
                                                    <input type="text" class="form-control" name="sub_bank_code" value="<?php echo (!empty($merchant) ? $merchant["sub_bank_code"]:""); ?>">
                                                    <span class="input-group-addon"> 帳號 </span>
                                                    <input type="text" class="form-control" name="bank_account" value="<?php echo (!empty($merchant) ? $merchant["bank_account"]:""); ?>">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">販售商品類型：</label>
                                        <div class="col-md-10">
                                            <?php if(empty($merchant)): ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                                    <select class="form-control" name="merchant_type">
                                                        <option value="">請選擇販售商品類型</option>
                                                        <?php foreach($merchant_config['merchant_type'] as $merchantTypeKey => $merchantType): ?>
                                                            <option value="<?php echo $merchantTypeKey; ?>"><?php echo $merchantType; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo (isset($merchant_config['merchant_type'][$merchant['merchant_type']]) ? $merchant_config['merchant_type'][$merchant['merchant_type']]:''); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商品類別：</label>
                                        <div class="col-md-10">
                                            <?php if(empty($merchant)): ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                                    <select class="form-control" name="business_type">
                                                        <option value="">請選擇商品類別</option>
                                                        <?php foreach($merchant_config['business_type'] as $businessTypeKey => $businessType): ?>
                                                            <option value="<?php echo $businessTypeKey; ?>"><?php echo $businessType; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group" style="line-height:32px;">

                                                    <?php echo (isset($merchant_config['business_type'][$merchant['business_type']]) ? $merchant_config['business_type'][$merchant['business_type']]:''); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店網址：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo $merchant['merchant_url']; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-external-link"></i></span>
                                                    <input type="text" placeholder="請填入商店網址" class="form-control" name="merchant_url" value="<?php echo (!empty($merchant) ? $merchant["merchant_url"]:""); ?>" />
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">商店簡介：</label>
                                        <div class="col-md-10">
                                            <?php if(!empty($merchant)): ?>
                                                <div class="input-group" style="line-height:32px;">
                                                    <?php echo nl2br($merchant['merchant_intro']); ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-doc"></i></span>
                                                    <textarea placeholder="請填入商店簡介" class="form-control" name="merchant_intro" style="height:100px;"><?php echo (!empty($merchant) ? $merchant["merchant_intro"]:""); ?></textarea>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="margiv-top-10">
                                        <div class="col-md-12">
                                            <input type="hidden" name="merchant_id" value="<?php echo (!empty($merchant) ? $merchant["merchant_id"]:"0"); ?>" />
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