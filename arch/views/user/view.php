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
            echo RHtmlHelper::showImage($thumbnail,$user->name, array('class'=>'img-thumbnail','width'=>'120px'))
            ?>
        </div>
        <div class="col-lg-10">
            <h2>
                <?=$user->name?>&nbsp;
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
                if ($canEdit) {
                    echo RHtmlHelper::linkAction('user', 'Edit', 'edit', $user->id, array('class' => 'btn btn-success'));
                }
                if ($canAdd) {
                    echo RHtmlHelper::linkAction('friend', '+ Add friend', 'add', $user->id, array('class' => 'btn btn-success'));
                }
                if ($canCancel) {
                    echo RHtmlHelper::linkAction('friend', '- Cancel friend', 'cancel', $user->id, array('class' => 'btn btn-success'));
                }
                echo '<div class="clearfix"></div>';
                ?>
            </div>
        </div>

    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li <?php if ($part == 'joins') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Joined Groups','view',$user->id)?></li>
            <li <?php if ($part == 'posts') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Posted Topics','view',[$user->id, 'posts'])?></li>
            <li <?php if ($part == 'likes') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Liked Topics','view',[$user->id, 'likes'])?></li>
            <li <?php if ($part == 'profile') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Profile','view',[$user->id, 'profile'])?></li>
        </ul>
    </div>
    <?php $skip = ['id', 'status', 'picture', 'privacy', 'permission', 'password', 'credits']; ?>
    <div class="panel-body">
        <?php if ($part == 'profile') { ?>
            <ul class="list-group">
            <?php
            foreach ($user->columns as $objCol => $dbCol) {
                if ($user->$objCol && !in_array($objCol, $skip)) {
                    echo "<li class='list-group-item'>";
                    switch ($objCol) {
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
        }
        echo '</ul>';
        ?>


    </div>

</div>