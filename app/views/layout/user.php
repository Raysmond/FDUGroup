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

    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/bootstrap-3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUrl; ?>/public/js/main.js"></script>
</head>

<body>
<?php
    echo $this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation'));
/*
$cache = RCacheFactory::create('RFileCacheHelper', Rays::app()->getCacheConfig());
if ( ($menuContent = $cache->get("user.menu", "user", 3600)) != FALSE ) {
    echo $menuContent;
}
else{
    $menuContent = $this->module('main_nav',array('id'=>'main_nav','name'=>'Main navigation'), true);
    $cache->set("user.menu", "user", $menuContent);
    echo $menuContent;
    unset($menuContent);
}
*/

?>

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
            <div>
                <?php $user = Rays::app()->getLoginUser(); if($user!=null): ?>
                    <div class="row user-profile-tiny">
                        <div class="col-lg-2">
                            <?php if(!isset($user->picture)||$user->picture=='') $user->picture=User::$defaults['picture'];
                                $thumbnail = RImageHelper::styleSrc($user->picture,$user::getPicOptions());
                            ?>
                            <a href="<?=RHtmlHelper::siteUrl('user/view/'.$user->id)?>" >
                            <?php
                                echo RHtmlHelper::showImage($thumbnail,$user->name, array('class'=>'img-thumbnail','width'=>'120px'))
                            ?>
                            </a>
                        </div>
                        <div class="col-lg-10">
                            <h2>
                                <?=RHtmlHelper::linkAction('user',$user->name,'view',$user->id)?>&nbsp;
                                <span class="badge badge-<?=Role::getRoleNameById($user->roleId);?>"><?=Role::getBadgeById($user->roleId);?></span>
                            </h2>
                            <div><?=RHtmlHelper::decode($user->intro)?></div>
                            <div><?=$user->region?>
                                <?php if ($user->weibo!='') { ?>
                                    <?php if ($user->region!='') { ?>|<?php } ?>
                                    Micro-Blog: <?=RHtmlHelper::link($user->weibo,$user->weibo,$user->weibo)?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <?php $this->module("user_home_nav", array('id'=>'user_home_nav','name'=>'User home navigation')); ?>
                </div>

                <div class="col-lg-9">
                    <div id="content">
                        <?php if(isset($content)) echo $content; ?>
                    </div>
                </div>
            </div>


        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

            <?php
            $this->module("friend_users",array('id'=>'friend_users','name'=>"Friends"));

            $cache = RCacheFactory::create('RFileCacheHelper', Rays::app()->getCacheConfig());

            if ( ($cacheContent = $cache->get("users", "new_users", 60)) != FALSE ) {
                echo $cacheContent;
            }
            else{
                $cacheContent =$this->module("new_users",array('id'=>'new_users','name'=>"New Users"),true);
                $cache->set("users", "new_users", $cacheContent);
                echo $cacheContent;
                unset($cacheContent);
            }

            $this->module("ads",array('id'=>'ads','name'=>"Ads"));
            ?>
        </div><!--/span-->
    </div><!--/row-->
    <hr>
    <footer>
        <p><?php echo RHtmlHelper::encode(Rays::getCopyright()); ?></p>
    </footer>

</div><!--/.container-->

<!-- Placed at the end of the document so the pages load faster -->
<?php
// link custom script files
echo RHtmlHelper::linkScriptArray(Rays::app()->getClientManager()->script);
?>
</body>
</html>