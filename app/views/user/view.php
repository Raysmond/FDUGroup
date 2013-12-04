<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div>
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
            <div class="navbar-left">
                <?php
                if ($canAdd) {
                    echo RHtmlHelper::linkAction('friend', '+ Add friend', 'add', $user->id, array('class' => 'btn btn-xs btn-success'));
                }
                if ($canCancel) {
                    echo RHtmlHelper::linkAction('friend', '- Cancel friend', 'cancel', $user->id, array('class' => 'btn btn-xs btn-success'));
                }
                echo '<div class="clearfix"></div>';
                ?>
            </div>
        </div>

    </div>
    <?php
    if ($user->status == User::STATUS_BLOCKED) {
        echo '<div class="panel-body">This user has been blocked.</div>';
    } else {
    ?>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li <?php if ($part == 'joins') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Joined Groups','view',$user->id)?></li>
            <li <?php if ($part == 'posts') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Posts','view',[$user->id, 'posts'])?></li>
            <li <?php if ($part == 'likes') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Favorites','view',[$user->id, 'likes'])?></li>
            <li <?php if ($part == 'profile') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Profile','view',[$user->id, 'profile'])?></li>
        </ul>
    </div>
    <?php $skip = ['id', 'status', 'picture', 'privacy', 'password', 'credits']; ?>
    <div class="panel-body">
            <?php
            if ($part == 'profile') {       //Profile of a User
            ?>
                <ul class="list-group">
                <?php
                foreach ($user->columns as $objCol => $dbCol) {
                    if ($user->$objCol && !in_array($objCol, $skip)) {
                        echo "<li class='list-group-item'>";
                        switch ($objCol) {
                            case "gender":
                                echo "Gender: " . User::getGenderName($user->gender);
                                break;
                            case "registerTime":
                                echo "Register time: " . $user->registerTime . "<br/>";
                                break;
                            case "qq":
                                echo "QQ: " . $user->qq . "<br/>";
                                break;
                            case "roleId":
                                echo "Role: " . User::$roles[$user->roleId - 1] . "<br/>";
                                break;
                            case "intro":
                                echo "Introduction: " . $user->$objCol . "<br/>";
                                break;
                            default:
                                echo ucfirst($objCol) . ": " . $user->$objCol . "<br/>";
                                break;
                        }
                        echo "</li>";
                    }
                }
                echo '</ul>';
            } else if ($part == 'joins') {          //Groups joined by a User
                if ($userGroup == null) {
                    echo "<p>This guy has not joined any groups!</p>";
                } else {
                    echo '<div class="row">';
                    foreach ($userGroup as $group) {

                        echo '<div class="col-6 col-sm-6 col-lg-4" style="height: 190px;">';
                        echo "<div class='panel panel-default' style='height: 170px;'>";
                        echo "<div class='panel-heading'>";
                        if (isset($group->picture) && $group->picture != '') {
                            //echo RHtmlHelper::showImage($group->picture,$group->name,array('style'=>'height:32px;'));
                        }
                        echo RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
                        echo "</div>";

                        echo "<div class='panel-body'>";
                        echo $group->memberCount . " members";
                        $content = strip_tags(RHtmlHelper::decode($group->intro));
                        if (mb_strlen($content) > 70) {
                            echo '<p>' . mb_substr($content, 0, 70, "UTF-8") . '...</p>';
                        } else echo '<p>' . ($content) . '</p>';

                        echo RHtmlHelper::linkAction('group', 'View details', 'detail', $group->id
                            , array('class' => 'btn btn-xs btn-info', 'style' => 'position:absolute;top:140px;right:30px;'));

                        echo "</div></div>";
                        echo "</div>";

                    }
                    echo '</div>';
                }
            } else
            if ($part == 'posts') {         //User published Topics
                if (!count($postTopics)) {
                    echo "<p>This guy has not posted any topics!</p>";
                } else {
            ?>
                <table class="table table-hover table-condensed">
                    <thead><tr><th>Title</th><th>Replies</th><th>Time</th><th>Last comment</th></tr></thead>
                    <tbody><?php

                    foreach ($postTopics as $topic) {
                        ?><tr><td><b><?=RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id)?></b></td>
                        <td><?=$topic->commentCount?></td>
                        <td><?=$topic->createdTime?></td>
                        <td><?=$topic->lastCommentTime?></td></tr><?php
                    }

                    ?></tbody>
                </table>
            <?php
                }
            } else
            if ($part == 'likes') {
                if (!count($likeTopics)) {
                    echo "<p>This guy has not posted any topics!</p>";
                } else {
                    ?>
                    <table class="table table-hover table-condensed">
                        <thead><tr><th>Title</th><th>Replies</th><th>Time</th><th>Last comment</th></tr></thead>
                        <tbody><?php

                        foreach ($likeTopics as $topic) {
                            ?><tr><td><b><?=RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id)?></b></td>
                            <td><?=$topic->commentCount?></td>
                            <td><?=$topic->createdTime?></td>
                            <td><?=$topic->lastCommentTime?></td></tr><?php
                        }

                        ?></tbody>
                    </table>
                <?php
                }
            }
        ?>
    </div>
    <?php
        }
    ?>
</div>