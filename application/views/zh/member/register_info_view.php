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
            <h3 class="form-title font-green">會員註冊</h3>
            <div class="tabbable-line">
                <?php if (isset($error_msg) && $error_msg) { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> <?=$error_msg?> </span>
                    </div>
                <?php } ?>
                
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
                        <div class="mt-element-step">
                            <div class="row step-background-thin">
                                <div class="col-md-4 bg-grey-steel mt-step-col active">
                                    <div class="mt-step-number">1</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">快速註冊</div>
                                    <div class="mt-step-content font-grey-cascade">填寫您的個人基本資料</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col">
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
                        <form class="register-form" id="personal_register_form" action="" method="post">
                            <p class="hint"> 請設定您的會員資料: </p>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">姓名</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="姓名" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">身份證字號</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="身份證字號" name="idno" id="idno" />
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">出生日期 年</label>
                                        <select name="birth_year" class="form-control">
                                            <option value="">出生日期 年</option>
                                            <?php for ($y = 1905; $y <= date('Y'); $y++): ?>
                                                <option value="<?= $y ?>"><?= $y ?>年</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">出生日期 月</label>
                                        <select name="birth_month" class="form-control">
                                            <option value="">出生日期 月</option>
                                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                                <option value="<?= $m ?>"><?= $m ?>月</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">出生日期 日</label>
                                        <select name="birth_day" class="form-control">
                                            <option value="">出生日期 日</option>
                                            <?php for ($d = 1; $d <= 31; $d++): ?>
                                                <option value="<?= $d ?>"><?= $d ?>日</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">行動電話</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="行動電話" name="mobile" />
                            </div>

                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">電子郵件</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="電子郵件" name="email" />
                            </div>

                            <p class="hint"> 請填寫您的預設管理者資訊: </p>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理帳號</label>
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="管理帳號" name="username" id="username" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理密碼</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="管理密碼" name="password" /> </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">確認管理密碼</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="確認管理密碼" name="rpassword" /> </div>
                            <div class="form-group margin-top-20 margin-bottom-20">
                                <label class="check">
                                    <input type="checkbox" name="tnc" /> I agree to the
                                    <a href="javascript:;"> Terms of Service </a> &
                                    <a href="javascript:;"> Privacy Policy </a>
                                </label>
                                <div id="register_tnc_error"> </div>
                            </div>                            
                            <div class="form-actions">
                                <a type="button" id="register-back-btn" class="btn btn-default" href='/login'>返回登入</a>
                                <button type="button" id="register-submit-btn" class="btn btn-success uppercase pull-right">下一步</button>
                            </div>
                        </form>

                        <div id="personal_user_terms" class="hidden">
                            <form method="post">
                            </form>
                        </div>
                        <!-- END REGISTRATION FORM -->
                    </div>
                    <div class="tab-pane" id="enterprise">
                        <div class="mt-element-step">
                            <div class="row step-background-thin">
                                <div class="col-md-4 bg-grey-steel mt-step-col active">
                                    <div class="mt-step-number">1</div>
                                    <div class="mt-step-title uppercase font-grey-cascade">填寫資料</div>
                                    <div class="mt-step-content font-grey-cascade">Purchasing the item</div>
                                </div>
                                <div class="col-md-4 bg-grey-steel mt-step-col">
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
                        <form class="register-form" id="enterprise_register_form" action="" method="post">
                            <p class="hint"> 請填寫您的企業資訊: </p>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">企業名稱</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="企業名稱" name="fullname" />
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">統一編號</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="統一編號" name="unino" id="unino" />
                            </div>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <label class="control-label visible-ie8 visible-ie9">公司電話</label>
                                <input class="form-control placeholder-no-fix" type="text" placeholder="公司電話" name="tel" />
                            </div>
                            <p class="hint"> 請填寫您的預設管理者資訊: </p>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理者姓名</label>
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="管理者姓名" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理者電子郵件</label>
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="管理者電子郵件" name="email" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理者行動電話</label>
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="管理者行動電話" name="mobile" />
                            </div>

                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理帳號</label>
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="管理帳號" name="username" id="e_username" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">管理密碼</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="enterprise_register_password" placeholder="管理密碼" name="password" />
                            </div>
                            <div class="form-group">
                                <label class="control-label visible-ie8 visible-ie9">確認管理密碼</label>
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="確認管理密碼" name="rpassword" />
                            </div>
                            <div class="form-group margin-top-20 margin-bottom-20">
                                <label class="check">
                                    <input type="checkbox" name="tnc" /> I agree to the
                                    <a href="javascript:;"> Terms of Service </a> &
                                    <a href="javascript:;"> Privacy Policy </a>
                                </label>
                                <div id="register_tnc_error"> </div>
                            </div>
                            <div class="form-actions">
                                <a type="button" id="register-back-btn" class="btn btn-default" href='/login'>返回登入</a>
                                <button type="button" id="register-submit-btn" class="btn btn-success uppercase pull-right">下一步</button>
                            </div>
                        </form>

                        <div id="enterprise_user_terms" class="hidden">
                            <form method="post">
                            </form>
                        </div>
                        <!-- END REGISTRATION FORM -->

                    </div>
                </div>
            </div>

            <div id="user_terms" class="hidden">
                <?=$register_terms?>
            </div>


        </div>
    </div>
    <div class="copyright"> 2016 © WeCanPay. 威肯科技股份有限公司. </div>

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
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/public/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/public/apps/js/register.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <!-- END THEME LAYOUT SCRIPTS -->

    <script>
        /*
        $("._next").on("click", function (e) {
            e.preventDefault();
            // var terms = $("#user_terms").clone().removeClass("hidden");
            var terms = $("#user_terms").html();
            var form = $(this).closest("form");
            var terms_div;

            if ($(form).attr('id') == 'personal_register_form'){
                terms_div = $('#personal_user_terms');
                
            }else {
                terms_div = $('#enterprise_user_terms');
            }

            form.hide();            
            // terms.appendTo(terms_div);
            terms_div.html(terms);

            terms_div.find('.scroller_block').slimScroll({
                height: '400px',
                railVisible: true,
                alwaysVisible: true
            });    
            return false;
        });       
        */
    </script>
</body>

</html>