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
    <link rel="shortcut icon" href="<?=$baseUrl ?>/public/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="<?=$baseUrl; ?>/public/bootstrap-3.0/css/bootstrap.min.css"/>

    <link rel="stylesheet" type="text/css" href="<?=$baseUrl; ?>/public/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl; ?>/public/css/theme.css"/>
    <?php
    // link custom css files
    echo RHtml::linkCssArray(Rays::app()->client()->css);
    ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script type="text/javascript" src="<?=$baseUrl; ?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$baseUrl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$baseUrl; ?>/public/js/main.js"></script>
    <script type="text/javascript" src="<?=$baseUrl; ?>/public/js/jquery.dotdotdot.min.js"></script>

</head>

<body>
<?php $self->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation')); ?>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">
    <nav id="admin-main-navbar" class="navbar navbar-default" role="navigation" style="z-index: 1001;">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $baseUrl."/admin"; ?>">Admin home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Link</a></li>-->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtml::linkAction('user','All users','admin')?></li>
                        <li><a href="#">Create new user</a></li>
                        <li><?=RHtml::linkAction('user','VIP applications','processVIP')?></li>
                    </ul>
                </li>

                <li><?php echo RHtml::linkAction('category',"Categories",'admin'); ?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Groups <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtml::linkAction('group',"Admin groups",'admin'); ?></li>
                        <li><?php echo RHtml::linkAction('group',"Groups recommendation",'recommend'); ?></li>
                        <li><?php echo RHtml::linkAction('group',"Find groups",'findAdmin'); ?></li>
                        <li><?php echo RHtml::linkAction('group',"Create new group",'buildAdmin'); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Topics <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtml::linkAction('post','Topics','admin')?></li>
                        <li><?=RHtml::linkAction('post','Active topics','active')?></li>
                    </ul>
                </li>

                <li><?=RHtml::linkAction('comment','Comment','admin')?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Messages <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtml::linkAction('message','Send a message','sendAdmin'); ?></li>
                        <li><a href="#">All messages</a></li>
                        <li><a href="#">new messages</a></li>
                    </ul>
                </li>

                <li><?=RHtml::linkAction('ads','Advertisement','admin')?></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">System configurations</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtml::linkAction('admin','System logs','logs')?></li>
                        <li><a href="#">Users accounting</a></li>
                        <li><a href="#">Topics report</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
     </div>

    <div class="row row-offcanvas row-offcanvas-right">
        <!--<div class="col-xs-12 col-sm-9"> -->
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <div id="messages">
                <?php echo RHtml::showFlashMessages(); ?>
            </div>

            <div id="content">
                <?php if (isset($content)) echo $content; ?>
            </div>

       <!-- </div> -->

        <!--
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation"> -->

            <?php
               // $self->module("new_users",array('id'=>'new_users','name'=>"New Users"));
            ?>

       <!-- </div>--><!--/span-->


    </div>

    <hr>

    <footer>
        <p><?php echo "© Copyright " . Rays::app()->getName() . " 2013, All Rights Reserved."; ?></p>
    </footer>

</div>
<!--/.container-->

<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtml::linkScriptArray(Rays::app()->client()->script);
?>
</body>

</html>