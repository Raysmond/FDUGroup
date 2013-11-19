<?php
/**
 * Author: Raysmond
 */
?>
<div class="row">
    <div class="col-lg-2">
        <?=RHtmlHelper::showImage($user->picture,$user->name, array('width'=>'120px'))?>
    </div>
    <div class="col-lg-10">
        <h2><?=$user->name?></h2>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-3">
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><?=RHtmlHelper::linkAction('user','Home page','home')?></li>
            <li><?=RHtmlHelper::linkAction('user','Profile','view',$user->id)?></li>
            <?php
            if(($count = $user->countUnreadMsgs())==0)
                echo "<li>".RHtmlHelper::linkAction("message","Messages","view",null)."</li>";
            else
            {
                echo '<li><a href="'.RHtmlHelper::siteUrl('message/view').'">';
                echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">'.$count.'</span></a></li>';
            }
            ?>
        </ul>
    </div>

    <div class="col-lg-9">
        <h2>Latest trends</h2>
        <?php
        foreach($topics as $topic){

            ?>
            <div class="row">
                <div class="col-lg-2">
                    <?php if($topic->user->picture==''){
                        $topic->user->picture = User::$defaults['picture'];
                    }?>
                   <?=RHtmlHelper::showImage($topic->user->picture,$topic->user->name,array('width'=>'64px'))?>

                </div>
                <div class="col-lg-10">
                    <div><?=RHtmlHelper::linkAction('user',$topic->user->name,'view',$topic->user->id)?> &nbsp;&nbsp;<?=$topic->createdTime?></div>
                    <div>
                        <?php
                        $topic->content = strip_tags(RHtmlHelper::decode($topic->content));
                        if (mb_strlen($topic->content) > 140) {
                            echo '<p>' . mb_substr($topic->content, 0, 140,'UTF-8') . '...</p>';
                        } else echo '<p>' . $topic->content . '</p>';
                        ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php
        }
        ?>
    </div>
</div>