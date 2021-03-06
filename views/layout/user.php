<?php
$baseUrl = Rays::app()->getBaseUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo RHtml::encode(Rays::app()->client()->getHeaderTitle()); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="description" content=""/>
    <link rel="shortcut icon" href="<?= $baseUrl ?>/public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/public/bootstrap-3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/public/css/non-responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/public/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/public/css/user.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>/public/css/theme.css"/>

    <?php
    // link custom css files
    echo RHtml::linkCssArray(Rays::app()->client()->css);
    ?>

    <script type="text/javascript" src="<?= $baseUrl ?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $baseUrl ?>/public/js/main.js"></script>
    <script type="text/javascript" src="<?= $baseUrl; ?>/public/js/jquery.dotdotdot.min.js"></script>
</head>

<body class="user-home">
<?php
$self->module('main_nav', array('id' => 'main_nav', 'name' => 'Main navigation'));
?>
<div id="main-wrapper" class="container">
    <?php $self->module("user_panel"); ?>
    <hr>
    <div class="row">
        <div class="col-sm-9">
            <div id="messages"><?= RHtml::showFlashMessages() ?></div>

            <div class="content-wrapper">
                <div id="content">
                    <?php $self->module("publish_form"); ?>
                    <?php if (isset($content)) echo $content; ?>
                </div>
            </div>

        </div>
        <!--/span-->

        <div class="col-sm-3" id="sidebar">

            <div class="navigation-wrapper">
                <?php $self->module("user_home_nav", array('id' => 'user_home_nav', 'name' => 'User home navigation')); ?>
            </div>
            <?php
            $self->module("friend_users");
            $self->module("ads");
            ?>
        </div>
        <!--/span-->
    </div>
    <!--/row-->
    <hr>
    <div id="footer" class="row">
        <div
            class="copyright col-lg-5"><?php echo "© Copyright " . Rays::app()->getName() . " 2013, All Rights Reserved."; ?></div>

        <div class="footer-links col-lg-7">
            <ul>
                <li><?= RHtml::linkAction('site', 'About us', 'about') ?></li>
                <li><?= RHtml::linkAction('site', 'Contact', 'contact') ?></li>
                <li><?= RHtml::linkAction('site', 'Help', 'help') ?></li>
            </ul>
        </div>
    </div>

</div>
<!--/.container-->

<p id="back-top" style="display: block;">
    <a href="javascript:void(0)"><span title='Back to top' id="button"></span></a>
</p>

<script>
    $(document).ready(function () {
        $("#back-top").hide();
        $(window).scroll(function () {
            if ($(window).scrollTop() > 200) {
                $("#back-top").fadeIn(300);
            }
            if ($(window).scrollTop() < 200) {
                $("#back-top").fadeOut(300);
            }
        });
    });

    $("#back-top").click(function () {
        $('body,html').animate({scrollTop: 0}, $(window).scrollTop() / 2);
    });
</script>

<!-- Placed at the end of the document so the pages load faster -->
<?= RHtml::linkScriptArray(Rays::app()->client()->script); ?>
</body>
</html>