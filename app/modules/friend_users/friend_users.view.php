<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Friends</h3></div>
    <div class="panel-body">
        <?php
        echo '<div class="row user-list">';
        if(empty($friends)){
            echo '<div>&nbsp;&nbsp;You don\'t have any friends yet!</div>';
        }
        foreach($friends as $friend){
            echo '<div class="user-item col-lg-4">';
            $picture = isset($friend->picture)&&$friend->picture!=''?$friend->picture:User::$defaults['picture'];
            $picture = RImageHelper::styleSrc($picture,User::getPicOptions());
            echo '<a href="'.RHtmlHelper::siteUrl('user/view/'.$friend->id).'">'.RHtmlHelper::showImage($picture,$friend->name,array('width'=>'64px','height'=>'64px')).'</a>';
            $name = $friend->name;
            if(mb_strlen($name)>7) $name = mb_substr($name,0,8)."..";
            echo RHtmlHelper::linkAction('user', $name, 'view', $friend->id,array('title'=>$friend->name))."  ";
            echo '</div>';
        }
        if ($friNumber) {
            echo '<div class="clearfix"></div>'.RHtmlHelper::linkAction('friend', 'Show all my '.$friNumber.' friends >>', 'myFriend', null, ['id' => 'list-all-friends']);
        }
        echo '</div>';
        ?>
    </div>
</div>
