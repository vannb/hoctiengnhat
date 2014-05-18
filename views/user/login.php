<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo isset($this->template->title)?$this->template->title:$this->template->default_title?></title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/plugins/gritter/jquery.gritter.css">
        <link rel="stylesheet" href="css/plugins/icheck/all.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/themes.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
        <script src="js/plugins/validation/jquery.validate.min.js"></script>
        <script src="js/plugins/validation/additional-methods.min.js"></script>
        <script src="js/plugins/icheck/jquery.icheck.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="<?php echo PATH ?>js/plugins/gritter/jquery.gritter.min.js"></script>
        <script src="js/eakroko.js"></script>
        <link rel="shortcut icon" href="img/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />
    </head>
    <body class='login'>
        <div class="wrapper">
            <h1>
                <a href="index.php"><img src="img/logo-big.png" alt="" class='retina-ready' width="59" height="49">
                    <?php echo isset($this->template->brand) ? $this->template->brand : DEFAULT_BRAND ?>
                </a>
            </h1>
            <div class="login-body">
                <h2>SIGN IN</h2>
                <form action="<?php echo $this->get_controller_url() ?>login" method='POST' class='form-validate' id="test">
                    <div class="control-group">
                        <div class="controls">
                            <input class="input-block-level" type="text" id="username" name="username"
                                   maxlength="32" placeholder="<?php echo translate("Tên đăng nhập") ?>"
                                   data-rule-required="true" data-rule-minlength="5"
                                   required="true" value="<?php echo get_post_var('username', '') ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="pw controls">
                            <input type="password" id="password" name="password"
                                   placeholder="<?php echo translate("Mật khẩu") ?>" size="60"
                                   class='complexify-me input-block-level'
                                   data-rule-required="true" data-rule-minlength="5"
                                   required="true">
                        </div>
                    </div>
                    <div class="submit">
                        <div class="remember">
                            <input type="checkbox" name="remember" class='icheck-me'
                                   data-skin="square" data-color="blue" id="remember">
                            <label for="remember">
                                <?php echo translate("Ghi nhớ") ?>
                            </label>
                        </div>
                        <input type="submit" value="<?php echo translate("Đăng nhập")?>"
                               class='btn btn-primary'>
                    </div>
                </form>
                <div class="forget">
                    <a href="<?php echo URL?>forgotpassword"><span><?php echo translate('Quên mật khẩu') ?></span></a>
                </div>
            </div>
        </div>
    </body>
</html>
