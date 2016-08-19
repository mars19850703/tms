<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>會員登入 - 威力付 WeCanPay</title>
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
        <link href="/public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/public/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="/public/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/public/apps/css/login.css" rel="stylesheet" type="text/css" />
        <link href="/public/layouts/layout3/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo" >
            <h1>威力付<sup>&reg;</sup>WeCanPay</h1>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <h3 class="form-title font-green">重設密碼</h3>
            <form class="login-form" action="" method="post" id="reset_pwd_form">
                <?php if (isset($error_msg) && $error_msg) { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> <?=$error_msg?> </span>
                    </div>
                <?php } ?>
                <input type="hidden" name="forget_data" value="<?=$forget_data?>">
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">請輸入新密碼</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="請輸入新密碼" name="password" id="password" />
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">請再一次輸入新密碼</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="請再一次輸入新密碼" name="rpassword" />
                </div>
                <div class="form-actions">
                    <a type="button" id="register-back-btn" class="btn btn-default" href='/login#personal'>返回登入</a>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">下一步</button>
                </div>
            </form>
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
        <script src="/public/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/public/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="/public/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="/public/apps/js/tms/general.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                WeCan.init("<?php echo $this->config->item("setting_api", "global_common"); ?>");
            });
        </script>
        <script src="/public/apps/js/tms/member/forget.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>