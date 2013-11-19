<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">New Users</h3></div>
    <div class="panel-body">
<?php
    echo '<div class="row">';
    foreach($users as $user){
        echo '<div class="col-6 col-sm-6 col-lg-4">';
        echo '<a href="'.RHtmlHelper::siteUrl('user/view/'.$user->id).'">'.RHtmlHelper::showImage(isset($user->picture)&&$user->picture!=''?$user->picture:User::$defaults['picture'],$user->name,array('width'=>'64px','height'=>'64px')).'</a>';
        echo RHtmlHelper::linkAction('user', $user->name, 'view', $user->id)."  ";
        echo '</div>';
    }
    echo '</div>';
?>

   </div>
    </div>