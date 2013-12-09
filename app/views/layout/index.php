<?php
$baseUrl = Rays::app()->getBaseUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo RHtmlHelper::encode(Rays::app()->getClientManager()->getHeaderTitle()); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="description" content=""/>
    <link rel="shortcut icon" href="<?=$baseUrl ?>/public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/public/bootstrap-3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/public/css/non-responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/public/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/public/css/theme.css"/>

    <?php
    // link custom css files
    echo RHtmlHelper::linkCssArray(Rays::app()->getClientManager()->css);
    ?>

    <script type="text/javascript" src="<?=$baseUrl?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>/public/js/main.js"></script>
</head>

<body class="index page-<?=Rays::router()->getController().'-'.Rays::router()->getAction()?>">
<?php
$this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation'));
?>

<div id="main-wrapper" class="container">
    <?php
        $this->module("group_categories",array('name'=>"Categories"));
        $this->module("posts_category");
    ?>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div id="messages">
                <?php
                    echo RHtmlHelper::showFlashMessages();
                ?>
            </div>

            <div class="content-wrapper">
                <div id="content">
                    <?php if(isset($content)) echo $content; ?>
                </div>
            </div>

        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

            <?php
            $this->module("help_nav");
            $this->module("contact_nav");

            $this->module("active_groups");
            $this->module("hot_posts");
            $this->module("friend_groups",array('id'=>'friend_groups','name'=>"Friend Groups"));
            $this->module("group_users",array('id'=>'group_users','name'=>"Group Users"));
            $this->module("ads",array('id'=>'ads','name'=>"Ads"));

            ?>
        </div><!--/span-->
    </div><!--/row-->
    <hr>
    <div id="footer" class="row">
        <div class="copyright col-lg-5"><?php echo RHtmlHelper::encode(Rays::getCopyright()); ?></div>

        <div class="footer-links col-lg-7">
            <ul>
                <li><?=RHtmlHelper::linkAction('site','About us','about')?></li>
                <li><?=RHtmlHelper::linkAction('site','Contact','contact')?></li>
                <li><?=RHtmlHelper::linkAction('site','Help','help')?></li>
            </ul>
        </div>
    </div>
</div><!--/.container-->

<p id="back-top" style="display: block;">
    <a href="javascript:void(0)"><span title='Back to top' id="button"></span></a>
</p>

<script>
    $(document).ready(function(){
        $("#back-top").hide();
        $(window).scroll(function(){
            if ($(window).scrollTop() > 200) {
                $("#back-top").fadeIn(300);
            }
            if ($(window).scrollTop() < 200) {
                $("#back-top").fadeOut(300);
            }
        });
    });

    $("#back-top").click(function() {
        $('body,html').animate({scrollTop:0},$(window).scrollTop() / 2);
    });
</script>
<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>
</html>