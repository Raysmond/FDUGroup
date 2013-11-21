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

    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/bootstrap-3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/public/css/main.css"/>
    <?php
        // link custom css files
        echo RHtmlHelper::linkCssArray(Rays::app()->getClientManager()->css);
    ?>
</head>

<body>
<?php $this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation')); ?>

<div class="container">

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
            <div id="content">
                <?php if(isset($content)) echo $content; ?>
            </div>

        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

            <?php
            $this->module("friend_users",array('id'=>'friend_users','name'=>"Friends"));
            $this->module("new_users",array('id'=>'new_users','name'=>"New Users"));
            ?>
        </div><!--/span-->
    </div><!--/row-->
    <hr>
    <footer>
        <p><?php echo RHtmlHelper::encode(Rays::getCopyright()); ?></p>
    </footer>

</div><!--/.container-->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/main.js"></script>
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>

</html>