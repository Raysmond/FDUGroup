<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?= $appName ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?php echo ($curUrl==''?'class="active"':''); ?>>
                    <a href="<?php echo $baseurl;?>">Home</a>
                </li>

                <li <?php echo ($curUrl=='site/about'?'class="active"':''); ?>>
                    <?php echo RHtmlHelper::linkAction("site","About","about", null); ?>
                </li>

                <li <?php echo ($curUrl=='site/contact'?'class="active"':''); ?>>
                    <?php echo RHtmlHelper::linkAction("site","Contact","contact", null); ?>
                </li>

                <li <?php echo ($curUrl=='group/find'?'class="active"':''); ?>>
                    <?php echo RHtmlHelper::linkAction("group","Find Group","find", null); ?>
                </li>

                <li <?php echo (Rays::app()->getHttpRequest()->urlMatch('group/view/*')?'class="active"':''); ?>>
                    <?php echo RHtmlHelper::linkAction("group","My Group","view", Rays::app()->isUserLogin()?Rays::app()->getLoginUser()->id:null); ?>
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
                        $pic = (isset($user->picture)&&$user->picture!='')?$user->picture:"public/images/default_pic.png"; ?>
                        <?=RHtmlHelper::showImage($pic,$user->name,array('class'=>'img-thumbnails'))?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><?=RHtmlHelper::linkAction("user","My Home Page","home")?></li>
                        <li><?=RHtmlHelper::linkAction("user","My profile","view",$user->id)?></li>
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