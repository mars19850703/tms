<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>會員註冊 - 威力付 WeCanPay</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="icon" href="<?=$global['resource']?>/apps/img/tms/tms-icon.ico">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="/public/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/public/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/public/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/public/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/public/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/public/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/public/apps/css/login.css" rel="stylesheet" type="text/css" />
        <link href="/public/layouts/layout3/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo font-white" >
            <h1>威力付<sup>&reg;</sup>WeCanPay</h1>
        </div>
        <!-- BEGIN LOGIN -->
        <div class="content register-width">
            <h3 class="form-title font-green">建立商店</h3>
            <div class="tabbable-line">
                <?php if (isset($error_msg) && $error_msg) { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> <?=$error_msg?> </span>
                    </div>
                <?php } ?>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <div class="mt-element-step">
                            <div class="row step-background-thin">
                                <div class="col-md-4 bg-grey-steel mt-step-col">
                                    <div class="mt-step-number">1</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">填寫資料</div>
                                    <div class="mt-step-content font-grey-cascade">Purchasing the item</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col active">
                                    <div class="mt-step-number">2</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">建立商店</div>
                                    <div class="mt-step-content font-grey-cascade">Complete your payment</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col">
                                    <div class="mt-step-number">3</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">完成註冊</div>
                                    <div class="mt-step-content font-grey-cascade">Receive item integration</div>
                                </div>
                            </div>
                        </div>

                        <!-- BEGIN REGISTRATION FORM -->
                        <form class="register-form" id="merchant_register_form" action="" method="post">
                            <p class="hint"> 請設定您的商店資料: </p>
                            <input type="hidden" name="merchant_data" value="<?=(isset($merchant_data))? $merchant_data : ''?>">
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">商店名稱</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="商店名稱" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">商店英文名稱</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="商店英文名稱" name="en_name" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">登記營業國家</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="登記營業國家" name="national_en" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">登記營業城市</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="登記營業城市" name="city_en" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">商店網址</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="商店網址" name="merchant_url" id="merchant_url" />
                            </div>                            
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">客服信箱</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="客服信箱" name="email" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">商店電話</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="商店電話" name="tel" />
                            </div>                            

                            <div class="row address-zon">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">縣市</label>
                                        <select name="city" id="city" class="form-control city">                                            
                                            <option value="">請選擇</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">鄉鎮市區</label>
                                        <select name="county" id="county" class="form-control county">                                            
                                            <option value="">請選擇</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">郵遞區號</label>
                                        <input name="zipcode" id="zipcode" class="form-control zipcode" type="text" placeholder="郵遞區號" autocomplete="off">                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">地址</label>
                                        <input class="form-control placeholder-no-fix" type="text" placeholder="地址" name="address" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">販售商品類型</label>
                                        <select name="merchant_type" id="merchant_type" class="form-control">                                            
                                            <option value="">請選擇販售商品類型</option>
                                            <?php if (isset($merchant_type)): ?>
                                                <?php foreach ($merchant_type as $value=>$name): ?>
                                                    <option value="<?=$value?>"><?=$name?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">商品類別</label>
                                        <select name="business_type" id="business_type" class="form-control">                                            
                                            <option value="">請選擇商品類別</option>
                                            <?php if (isset($business_type)): ?>
                                                <?php foreach ($business_type as $value=>$name): ?>
                                                    <option value="<?=$value?>"><?=$name?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label visible-ie8 visible-ie9">商店簡介</label>
                                <textarea class="form-control" autocomplete="off" placeholder="商店簡介" rows="4" name="intro" id="intro" /></textarea> </div>


                            <p class="hint"> 請設定您的帳戶資料: </p>
                            <div class="row">
                                <div class="col-md-12">                                    
                                    <div class="col-md-4 form-group">
                                        <select class="form-control" name="bank">
                                            <option value="">請選擇銀行</option>
                                            <?php if (isset($bankCode)): ?>
                                                <?php foreach($bankCode as $bank): ?>
                                                    <option value="<?php echo $bank['code'] . '-' . $bank['name']; ?>"><?php echo $bank['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" class="form-control" placeholder="分行代碼" name="sub_bank_code">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" class="form-control" placeholder="帳號" name="bank_account">
                                    </div>                                    
                                </div>
                            </div>

                            
                            
                            <div class="form-actions">
                                <!-- <a type="button" id="register-back-btn" class="btn btn-default" href='/login'>返回登入</a> -->
                                <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">下一步</button>
                            </div>
                        </form>
     
                        <!-- END REGISTRATION FORM -->
                    </div>

                </div>
            </div>            
        </div>
    </div>
    <div class="copyright">
        <?=$global['company']['since']?> &copy; <?=$website['meta']['title']?> by <?=$global['company']['name']?>
    </div>

    <!--[if lt IE 9]>
    <script src="/public/global/plugins/respond.min.js"></script>
    <script src="/public/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="/public/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/public/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/autosize/autosize.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="/public/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/public/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/public/apps/js/tms/aj-address.js" type="text/javascript"></script>
    <script src="/public/apps/js/tms/general.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            WeCan.init("<?php echo $this->config->item("setting_api", "global_common"); ?>");
        });
    </script>
    <script src="/public/apps/js/tms/member/register.js" type="text/javascript"></script>    
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>