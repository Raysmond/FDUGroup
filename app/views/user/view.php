<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>

<?php
Rays::css("/public/css/post.css");
?>
<div class="panel panel-default">
    <div class="panel-body">

        <div class="user-profile-tiny">
            <?=$this->module('user_panel',array('userId'=>$user->id, 'viewUser' => true));?>
            <div class="navbar-right">
                <?php
                if (isset($canAdd)&&$canAdd) {
                    echo RHtmlHelper::linkAction('friend', '+ Add friend', 'add', $user->id, array('class' => 'btn btn-xs btn-info'));
                }
                if (isset($canCancel)&&$canCancel) {
                    echo RHtmlHelper::linkAction('friend', '- Cancel friend', 'cancel', $user->id, array('class' => 'btn btn-xs btn-danger'));
                }
                echo '<div class="clearfix"></div>';
                ?>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

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
                    } else if ($part == 'posts') {         //User published Topics
                            $this->renderPartial("_common._posts_table",array('posts'=>$postTopics,'showGroup'=>true),false);
                        } else if ($part == 'likes') {
                                $this->renderPartial("_common._posts_table",array('posts'=>$likeTopics,'showAuthor'=>true,'showGroup'=>true),false);
                            }
                    ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>