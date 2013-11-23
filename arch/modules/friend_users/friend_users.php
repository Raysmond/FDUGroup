<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">Friends</h3></div>
    <div class="panel-body">
        <?php
        echo '<div class="row user-list">';
        if(empty($friends)){
            echo '<div>&nbsp;&nbsp;You don\'t have any friends yet!</div>';
        }
        foreach($friends as $friend){
            echo '<div class="user-item col-lg-4">';
            echo '<a href="'.RHtmlHelper::siteUrl('user/view/'.$friend->id).'">'.RHtmlHelper::showImage(isset($friend->picture)&&$friend->picture!=''?$friend->picture:User::$defaults['picture'],$friend->name,array('width'=>'64px','height'=>'64px')).'</a>';
            $name = $friend->name;
            if(mb_strlen($name)>7) $name = mb_substr($name,0,8)."..";
            echo RHtmlHelper::linkAction('user', $name, 'view', $friend->id,array('title'=>$friend->name))."  ";
            echo '</div>';
        }
        echo '</div>';
        ?>
    </div>
    </div>
