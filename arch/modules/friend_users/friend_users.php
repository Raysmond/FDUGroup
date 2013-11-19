<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">Friends</h3></div>
    <div class="panel-body">
        <?php
        echo '<div class="row">';
        foreach($friends as $friend){
            echo '<div class="col-6 col-sm-6 col-lg-4">';
            echo '<a href="'.RHtmlHelper::siteUrl('user/view/'.$friend->id).'">'.RHtmlHelper::showImage(isset($friend->picture)&&$friend->picture!=''?$friend->picture:User::$defaults['picture'],$friend->name,array('width'=>'64px','height'=>'64px')).'</a>';
            echo RHtmlHelper::linkAction('user', $friend->name, 'view', $friend->id)."  ";
            echo '</div>';
        }
        echo '</div>';
        ?>
    </div>
    </div>
