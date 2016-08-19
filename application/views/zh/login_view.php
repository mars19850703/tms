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
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
            <h3 class="form-title font-green">會員登入</h3>
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#personal" data-toggle="tab" aria-expanded="true"> 個人會員 </a>
                    </li>
                    <li class="">
                        <a href="#enterprise" data-toggle="tab" aria-expanded="false"> 企業會員 </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <form class="login-form" action="" method="post" id="personal_login_form">
                            <?php if (isset($error_msg) && $error_msg) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span> <?=$error_msg?> </span>
                                </div>
                            <?php } ?>
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span> 帳號或密碼錯誤 </span>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">帳號</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="帳號" name="username" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">密碼</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="密碼" name="password" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">驗證碼</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="驗證碼" name="check_code" /> </div>
                            <div class="form-group">
                                <img id="captcha_img" src="<?=base_url('login/captcha')?>" /> <a href="#" id="captcha">更換驗證碼</a>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="peronsal_login" <?=(!$this->session->lock_login)? '' : 'disabled'?> class="btn green uppercase">個人會員登入</button>
                                <a href="/member/forget#personal" id="forget-password" class="forget-password">忘記密碼?</a>
                            </div>
                            <div class="create-account">
                                <p>
                                    <a href="/member/register#personal" id="register-btn" class="uppercase">註冊個人會員</a>
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="enterprise">
                        <form class="login-form" action="" method="post" id="enterprise_login_form">
                            <?php if (isset($error_msg) && $error_msg) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span> <?=$error_msg?> </span>
                                </div>
                            <?php } ?>
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span> 統編或帳號、密碼錯誤 </span>
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">公司統一編號</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="公司統一編號" name="unino" /> </div>

                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">管理者帳號</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="管理者帳號" name="username" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理者密碼</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="管理者密碼" name="password" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">驗證碼</label>
                                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="驗證碼" name="check_code" /> </div>
                            <div class="form-group">
                                <img id="enterprise_captcha_img" src="<?=base_url('login/captcha')?>" /> <a href="#" id="enterprise_captcha">更換驗證碼</a>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="enterprise_login" <?=(!$this->session->lock_login)? '' : 'disabled'?> class="btn green uppercase">企業會員登入</button>
                                <a href="/member/forget#enterprise" id="forget-password" class="forget-password">忘記密碼?</a>
                            </div>
                            <div class="create-account">
                                <p>
                                    <a href="/member/register#enterprise" id="register-btn" class="uppercase">註冊企業會員</a>
                                </p>
                            </div>
                        </form>
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
        <script src="/public/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/public/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="/public/apps/js/tms/general.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                WeCan.init("<?php echo $this->config->item("setting_api", "global_common"); ?>");
            });
        </script>
        <script src="/public/apps/js/tms/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>