<div class="panel panel-default">
    <div class="panel-heading">Friends</div>
    <div class="panel-body">
        <?php
        echo '<div class="user-list">';
        if(empty($friends)){
            echo '<div>&nbsp;&nbsp;You don\'t have any friends yet!</div>';
        }
        foreach($friends as $friend){
            echo '<div class="user-item col-lg-4" style="overflow: hidden;height: 80px;">';
            $picture = isset($friend->picture)&&$friend->picture!=''?$friend->picture:User::$defaults['picture'];
            $picture = RImage::styleSrc($picture,User::getPicOptions());
            echo '<a href="'.RHtml::siteUrl('user/view/'.$friend->id).'">'.RHtml::image($picture,$friend->name,array('width'=>'58px','height'=>'58px')).'</a>';
            $name = $friend->name;
            if(mb_strlen($name)>7) $name = mb_substr($name,0,7)."..";
            echo RHtml::linkAction('user', $name, 'view', $friend->id,array('title'=>$friend->name))."  ";
            echo '</div>';
        }
//        if ($friNumber) {
//            echo '<div class="clearfix"></div>'.RHtml::linkAction('friend', 'Show all my '.$friNumber.' friends >>', 'myFriend', null, ['id' => 'list-all-friends']);
//        }
        echo '</div>';
        ?>
    </div>
</div>
