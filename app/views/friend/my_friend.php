<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        My Friends (<?=$friNumber?>)
        <div class="navbar-right">
            <a class="btn btn-xs btn-success" title="Find users" href="<?=RHtmlHelper::siteUrl('user/find')?>">
                <span class="glyphicon glyphicon-search">&nbsp;</span>Find Users
            </a>
        </div>
    </div>
    <div class="panel-body">
        <div class="user-list">
        <?php
            if(empty($friends)){
                echo '<div>&nbsp;&nbsp;You don\'t have any friends yet!</div>';
            }
            foreach ($friends as $friend) {
                echo '<div class="user-item col-lg-2">';
                $friend->picture = $friend->picture!=''?$friend->picture:User::$defaults['picture'];
                $picture = RImageHelper::styleSrc($friend->picture,User::getPicOptions());
                echo '<a href="' . RHtmlHelper::siteUrl('user/view/' . $friend->id) . '">' . RHtmlHelper::showImage($picture,$friend->name,array("width"=>"64px","height"=>"64px")). '</a>';
                echo '<br/>';
                $name = $friend->name;
                if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                echo RHtmlHelper::linkAction('user', $name, 'view', $friend->id, array('title' => $friend->name)) . "  ";
                echo '</div>';
            }
        ?>
        </div>
        <div class="clearfix"></div>
        <div>
            <?= $pager ?>
        </div>
    </div>
</div>
