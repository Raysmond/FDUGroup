<div id="main-navigation">
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= RHtmlHelper::linkAction("",$appName,"",null,array('class'=>'navbar-brand')); ?>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/home','user','user/'), $curUrl)) ? 'class="active"' : "" ?>>
                        <?= RHtmlHelper::linkAction("user","Home","home"); ?>
                    </li>
                    <li <?= ($curUrl=='group/find'?'class="active"':''); ?>>
                        <?= RHtmlHelper::linkAction("group","Find Groups","find"); ?>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php
                    // not login
                    if(!isset($user)){
                        echo "<li>".RHtmlHelper::linkAction("user","Login","login",null)."</li>";
                        echo "<li>".RHtmlHelper::linkAction("user","Register","register",null)."</li>";

                    }
                    else{
                        if($isAdmin){
                            echo '<li>'.RHtmlHelper::linkAction('admin','Admin',null,null,array('style'=>'font-weight: bold;'))."</li>";
                        }
                        ?>
                        <li class="dropdown">
                            <a href="#" id="account-dropdown" class="dropdown-toggle" data-toggle="dropdown" >
                                <span class="username"><?=$user->name?></span>
                                <?php
                                $pic = (isset($user->picture)&&$user->picture!='')?$user->picture:"public/images/default_pic.png";
                                $pic = RImageHelper::styleSrc($pic,User::getPicOptions());
                                ?>
                                <?=RHtmlHelper::showImage($pic,$user->name,array('class'=>'img-thumbnails'))?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><?=RHtmlHelper::linkAction("user","Home Page","home")?></li>
                                <li><?=RHtmlHelper::linkAction("user","Personal Page","view",$user->id)?></li>
                                <li role="presentation" class="divider"></li>
                                <?php
                                if(($count = Rays::app()->getLoginUser()->countUnreadMsgs())==0){
                                    echo "<li>".RHtmlHelper::linkAction("message","Messages","view",null)."</li>";
                                }
                                else{
                                    echo '<li><a href="'.RHtmlHelper::siteUrl('message/view').'">';
                                    echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">'.$count.'</span></a></li>';
                                }
                                ?>
                                <li role="presentation" class="divider"></li>
                                <li><?=RHtmlHelper::linkAction("user","Logout","logout",null)?></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </div><!-- /.navbar -->
</div>
