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

            <h3 class="form-title font-green"><?= $form_title ?></h3>
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-green"></i>
                        <span class="caption-subject font-green bold uppercase"><?= $portlet_caption ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <blockquote>
                        <p><?= $form_message ?></p>
                    </blockquote>
                </div>
            </div>
            <div class="form-actions">
                <a type="button" id="register-back-btn" class="btn btn-default" href='<?=(isset($url))? $url : '/login#enterprise'?>'><?=(isset($link_name))? $link_name : '返回登入'?></a>
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
        <!-- <script src="/public/apps/js/tms/login.js" type="text/javascript"></script> -->
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>