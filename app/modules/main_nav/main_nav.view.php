<div id="main-navigation">
    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="logo" href="<?=Rays::baseUrl()?>" class="navbar-brand">
                    <?=RHtmlHelper::showImage("public/images/logo.png")?>
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if(Rays::isLogin()){
                        ?>
                        <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/home','user','user/'), $curUrl)) ? 'class="active"' : "" ?>>
                            <?= RHtmlHelper::linkAction("user","Home","home"); ?>
                        </li>
                    <?php
                    }
                    ?>
                    <li <?= ($curUrl=='group/find'?'class="active"':''); ?>>
                        <?= RHtmlHelper::linkAction("group","Find groups","find"); ?>
                    </li>
                    <li <?= ($curUrl=='post/find'?'class="active"':''); ?>>
                        <?= RHtmlHelper::linkAction("post","Find posts","find"); ?>
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
                        $countMessages = Rays::user()->countUnreadMsgs();
                        if($isAdmin){
                            echo '<li>'.RHtmlHelper::linkAction('admin','Admin',null,null,array('style'=>'font-weight: bold;'))."</li>";
                        }
                        ?>
                        <li class="dropdown">
                            <a href="#" id="account-dropdown" class="dropdown-toggle" data-toggle="dropdown" >
                                <?php
                                $pic = (isset($user->picture)&&$user->picture!='')?$user->picture:"public/images/default_pic.png";
                                $pic = RImageHelper::styleSrc($pic,User::getPicOptions());
                                ?>
                                <?=RHtmlHelper::showImage($pic,$user->name,array('class'=>'img-thumbnails'))?>
                                <span class="username"><?=$user->name?></span>
                                <?php if($countMessages!=0): ?>
                                <span class="badge"><?=$countMessages?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><?=RHtmlHelper::linkAction("user","Home Page","home")?></li>
                                <li><?=RHtmlHelper::linkAction("user","Personal Page","view",$user->id)?></li>
                                <li role="presentation" class="divider"></li>
                                <?php
                                if($countMessages==0){
                                    echo "<li>".RHtmlHelper::linkAction("message","Messages","view",null)."</li>";
                                }
                                else{
                                    echo '<li><a href="'.RHtmlHelper::siteUrl('message/view').'">';
                                    echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">'.$countMessages.'</span></a></li>';
                                }
                                ?>
                                <li role="presentation" class="divider"></li>
                                <li><?=RHtmlHelper::linkAction("user","Logout","logout",null)?></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>

                <form class="navbar-form navbar-right" role="search" method="post" action="<?=RHtmlHelper::siteUrl("group/find")?>">
                     <input type="text" id="searchstr" name="searchstr" value="<?=(isset($_POST['searchstr'])?$_POST['searchstr']:"")?>" class="form-control" placeholder="Search groups">
                </form>

            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </div><!-- /.navbar -->
</div>
