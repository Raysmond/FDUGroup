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
    <?php
    // link custom css files
    echo RHtmlHelper::linkCssArray(Rays::app()->getClientManager()->css);
    ?>
</head>

<body>
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo RHtmlHelper::encode(Rays::app()->name); ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php $curUrl = Rays::app()->getHttpRequest()->getRequestUriInfo(); //like: site/about ?>
                <li <?php echo($curUrl == '' ? 'class="active"' : ''); ?>><a href="<?php echo $baseurl; ?>">Home</a>
                </li>
                <li <?php echo($curUrl == 'site/about' ? 'class="active"' : ''); ?>><?php echo RHtmlHelper::linkAction("site", "About", "about", null); ?></li>
                <li <?php echo($curUrl == 'site/contact' ? 'class="active"' : ''); ?>><?php echo RHtmlHelper::linkAction("site", "Contact", "contact", null); ?></li>
                <li <?php echo($curUrl == 'group/find' ? 'class="active"' : ''); ?>><?php echo RHtmlHelper::linkAction("group", "Find Group", "find", null); ?></li>
                <li <?php echo($this->getHttpRequest()->urlMatch('group/view/*') ? 'class="active"' : ''); ?>>
                    <?php echo RHtmlHelper::linkAction("group", "My Group", "view", Rays::app()->isUserLogin() ? Rays::app()->getLoginUser()->id : null); ?></li>
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <?php
                if (!Rays::app()->isUserLogin()) {
                    echo "<li>" . RHtmlHelper::linkAction("user", "Login", "login", null) . "</li>";
                    echo "<li>" . RHtmlHelper::linkAction("user", "Register", "register", null) . "</li>";

                } else {
                    $user = Rays::app()->getLoginUser();
                    if($user->roleId==Role::ADMINISTRATOR_ID)
                    {
                        echo '<li>'.RHtmlHelper::linkAction('admin','Administration')."</li>";
                    }
                    echo '<li class="dropdown">';

                    // echo RHtmlHelper::linkAction("user",Rays::app()->getLoginUser()->name,"view",Rays::app()->getLoginUser()->id,
                    //     array('id'=>'account-dropdown','class'=>'dropdown-toggle','data-toggle'=>'dropdown'));
                    echo '<a href="#" id="account-dropdown" class="dropdown-toggle" data-toggle="dropdown" >';
                    echo '<span class="username">' . $user->name . '</span>';
                    $pic = (isset($user->picture) && $user->picture != '') ? $user->picture : "public/images/default_pic.png";
                    echo RHtmlHelper::showImage($pic, $user->name, array('class' => 'img-thumbnails'));
                    echo '</a>';

                    echo '<ul class="dropdown-menu">';
                    echo "<li>".RHtmlHelper::linkAction("user","My Home Page","home")."</li>";
                    echo "<li>" . RHtmlHelper::linkAction("user", "My profile", "view", Rays::app()->getLoginUser()->id) . "</li>";

                    echo '<li role="presentation" class="divider"></li>';

                    if (($count = Rays::app()->getLoginUser()->countUnreadMsgs()) == 0)
                        echo "<li>" . RHtmlHelper::linkAction("message", "Messages", "view", null) . "</li>";
                    else {
                        echo '<li><a href="' . RHtmlHelper::siteUrl('message/view') . '">';
                        echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">' . $count . '</span></a></li>';
                    }
                    echo '<li role="presentation" class="divider"></li>';
                    echo "<li>" . RHtmlHelper::linkAction("user", "Logout", "logout", null) . "</li>";
                    echo '</ul>';
                    echo '</li>';

                }
                ?>
            </ul>
        </div>
        <!-- /.nav-collapse -->
    </div>
    <!-- /.container -->
</div>
<!-- /.navbar -->

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">
    <nav class="navbar navbar-default" role="navigation">
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
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtmlHelper::linkAction('category',"All categories",'all'); ?></li>
                        <li><?php echo RHtmlHelper::linkAction('category',"New category",'new'); ?></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Groups <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo RHtmlHelper::linkAction('group',"Admin groups",'admin'); ?></li>
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
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">System configurations</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">System logs</a></li>
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

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $baseurl; ?>/public/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $baseurl; ?>/public/js/main.js"></script>
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>

</html>