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
            <h3 class="form-title font-green">手機驗證</h3>
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
                                    <div class="mt-step-title uppercase font-grey-cascade">快速註冊</div>
                                    <div class="mt-step-content font-grey-cascade">填寫您的個人基本資料</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col active">
                                    <div class="mt-step-number">2</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">手機驗證</div>
                                    <div class="mt-step-content font-grey-cascade">驗證您的行動電話號碼</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col">
                                    <div class="mt-step-number">3</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">完成註冊</div>
                                    <div class="mt-step-content font-grey-cascade">歡迎您使用各項服務</div>
                                </div>
                            </div>
                        </div>

                        <!-- BEGIN REGISTRATION FORM -->
                        <div class="row">
                            <div class="col-md-4">
                                <img width="255" src="/public/apps/img/_temp/phone.png">
                            </div>
                            <div class="col-md-8">
                                <form class="register-form form-inline" id="otp_register_form" action="/member/register/otp_validate" method="post">
                                    <p class="hint"> 威力付將發送一組簡訊認證碼至您所設定的手機號碼 </p>
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">手機</label>
                                        <input class="form-control placeholder-no-fix input-medium" type="text" placeholder="手機" disabled id="mobile" name="mobile" value="<?=(isset($mobile))? $mobile : ''?>" />
                                        <button type="button" id="otp_resend_btn" <?=(isset($show_send_otp) && $show_send_otp == '0')? '' : 'disabled'?> class="btn btn-success uppercase">重新發送</button>
                                    </div>
                                    <hr>
                                    <p class="hint"> 請於驗證碼有效時間內，輸入發送至您的手機號碼之簡訊認證碼。 </p>
                                    <div id="otp_block" class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">驗證碼</label>
                                        <input class="form-control placeholder-no-fix input-medium" type="text" autocomplete="off" placeholder="驗證碼" name="otp_code" id="otp_code" />
                                        <span class="font-red-mint" id="otp_message"></span>
                                    </div>  
                                    <p class="lead"> 
                                        驗證有效時間：<span id="counter_text">05:00</span>
                                    </p>                                    
                                    <div class="form-actions">
                                        <button type="button" id="otp_submit_btn" class="btn btn-success uppercase">驗證</button>
                                        <a type="button" id="otp_cancel_btn" class="btn btn-default" href='/member/register#psersonal'>取消</a>                                        
                                    </div>
                                </form>
                            </div>
                        </div>
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
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="/public/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="/public/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <script src="/public/apps/js/tms/general.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            WeCan.init("<?php echo $this->config->item("setting_api", "global_common"); ?>");
        });
    </script>
    <?php if (isset($stop_time)){ ?>
    <script>
        var stopTime = "<?=$stop_time?>",
            showHidden = "<?=$show_send_otp?>",
            showOnceMessage = "<?=$show_send_otp?>";
    </script>
    <?php } ?>
    <!-- BEGIN PAGE LEVEL SCRIPTS -->    
    <script src="/public/apps/js/tms/member/otp.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->    
</body>

</html>