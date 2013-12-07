<?php
$baseurl = Rays::app()->getBaseUrl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo RHtmlHelper::encode(Rays::app()->getClientManager()->getHeaderTitle()); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="description" content=""/>

    <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>/public/bootstrap-3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>/public/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseurl; ?>/public/css/theme.css"/>
    <?php
    // link custom css files
    echo RHtmlHelper::linkCssArray(Rays::app()->getClientManager()->css);
    ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script type="text/javascript" src="<?php echo $baseurl; ?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/public/js/main.js"></script>

</head>

<body>
<?php $this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation')); ?>

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
            <a class="navbar-brand" href="<?php echo $baseurl."/admin"; ?>">Admin home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Link</a></li>-->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtmlHelper::linkAction('user','All users','admin')?></li>
                        <li><a href="#">Create new user</a></li>
                        <li><?=RHtmlHelper::linkAction('user','VIP applications','processVIP')?></li>
                    </ul>
                </li>

                <li><?php echo RHtmlHelper::linkAction('category',"Categories",'admin'); ?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Groups <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtmlHelper::linkAction('group',"Admin groups",'admin'); ?></li>
                        <li><?php echo RHtmlHelper::linkAction('group',"Groups recommendation",'recommend'); ?></li>
                        <li><?php echo RHtmlHelper::linkAction('group',"Find groups",'findAdmin'); ?></li>
                        <li><?php echo RHtmlHelper::linkAction('group',"Create new group",'buildAdmin'); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Topics <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtmlHelper::linkAction('post','Topics','admin')?></li>
                        <li><?=RHtmlHelper::linkAction('post','Active topics','active')?></li>
                    </ul>
                </li>

                <li><?=RHtmlHelper::linkAction('comment','Comment','admin')?></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Messages <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtmlHelper::linkAction('message','Send a message','sendAdmin'); ?></li>
                        <li><a href="#">All messages</a></li>
                        <li><a href="#">new messages</a></li>
                    </ul>
                </li>

                <li><?=RHtmlHelper::linkAction('ads','Advertisement','admin')?></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">System configurations</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?=RHtmlHelper::linkAction('admin','System logs','logs')?></li>
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
                <?php echo RHtmlHelper::showFlashMessages(); ?>
            </div>

            <div id="content">
                <?php if (isset($content)) echo $content; ?>
            </div>

       <!-- </div> -->

        <!--
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation"> -->

            <?php
               // $this->module("new_users",array('id'=>'new_users','name'=>"New Users"));
            ?>

       <!-- </div>--><!--/span-->


    </div>

    <hr>

    <footer>
        <p><?php echo RHtmlHelper::encode(Rays::getCopyright()); ?></p>
    </footer>

</div>
<!--/.container-->

<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>

</html>