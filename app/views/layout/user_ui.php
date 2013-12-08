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
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/bootstrap-3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/css/non-responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/css/theme.css"/>

    <?php
    // link custom css files
    echo RHtmlHelper::linkCssArray(Rays::app()->getClientManager()->css);
    ?>

    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/main.js"></script>
</head>

<body class=" page-<?=Rays::router()->getController().'-'.Rays::router()->getAction()?>">
<?php
$this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation'));
?>

<div id="main-wrapper" class="container">
    <div id="messages">
        <?php
        echo RHtmlHelper::showFlashMessages();
        ?>
    </div>

    <div class="content-wrapper">
        <div id="content" style="position:relative;">
            <?php if(isset($content)) echo $content; ?>
        </div>
    </div>

    <div id="footer" class="container user-login-register-footer">
        <hr>
        <div class="copyright col-lg-5"><?php echo RHtmlHelper::encode(Rays::getCopyright()); ?></div>

        <div class="footer-links col-lg-7">
            <ul>
                <li><?=RHtmlHelper::linkAction('site','About us','about')?></li>
                <li><?=RHtmlHelper::linkAction('site','Contact','contact')?></li>
                <li><?=RHtmlHelper::linkAction('site','Help','help')?></li>
            </ul>
        </div>
    </div>
    <div class="site-background">
        <?=RHtmlHelper::showImage('/public/images/background-'.rand(1,4).'.jpg', '',['style' => 'width: 100%; height: auto; top: -312.5px;'])?>
    </div>
</div><!--/.container-->

<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>
</html>