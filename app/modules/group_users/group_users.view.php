<?php
/**
 * Group users module view file.
 * @author: Raysmond
 */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Latest group users</h3>
    </div>
    <div class="panel-body">
        <?php
            if(count($users)==0){
                echo 'No group users';
            }
            else{
                echo '<div class="row user-list">';
                foreach($users as $user){
                    echo '<div class="user-item col-lg-4">';
                    $user->picture = $user->picture!=''?$user->picture:User::$defaults['picture'];
                    $picture = RImageHelper::styleSrc($user->picture,User::getPicOptions());
                    echo '<a href="' . RHtmlHelper::siteUrl('user/view/' . $user->id) . '">' . RHtmlHelper::showImage($picture,$user->name,array("width"=>"64px","height"=>"64px")). '</a>';
                    $name = $user->name;
                    if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                    echo RHtmlHelper::linkAction('user', $name, 'view', $user->id, array('title' => $user->name)) . "  ";
                    echo '</div>';
                }
                echo '</div>';
                echo '<span class="glyphicon glyphicon-user"></span>&nbsp;'.RHtmlHelper::linkAction('group',"All group members",'members',$groupId);
            }
        ?>
    </div>
</div>