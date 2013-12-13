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

<body class="index page-<?=Rays::router()->getControllerId().'-'.Rays::router()->getActionId()?>">
<?php
$this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation'));
?>

<div id="main-wrapper" class="container">
    <div class="row row-offcanvas row-offcanvas-right">

            <div id="messages">
                <?php
                echo RHtmlHelper::showFlashMessages();
                ?>
            </div>
            <div class="content-wrapper">
                <div id="content"">
                    <?php if(isset($content)) echo $content; ?>
                </div>
            </div>

    </div><!--/row-->

    <div id="footer" class="row">
        <hr>
        <div class="copyright col-lg-5"><?php echo "© Copyright " . Rays::app()->name . " 2013, All Rights Reserved."; ?></div>

        <div class="footer-links col-lg-7">
            <ul>
                <li><?=RHtmlHelper::linkAction('site','About us','about')?></li>
                <li><?=RHtmlHelper::linkAction('site','Contact','contact')?></li>
                <li><?=RHtmlHelper::linkAction('site','Help','help')?></li>
            </ul>
        </div>
    </div>
</div><!--/.container-->
<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>
</html>