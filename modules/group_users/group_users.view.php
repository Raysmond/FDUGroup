<?php
/**
 * Group users module view file.
 * @author: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Latest group users</h3>
    </div>
    <div class="panel-body">
        <?php
            if(count($users)==0){
                echo 'No group users';
            }
            else{
                echo '<div class="user-list">';
                foreach($users as $user){
                    echo '<div class="user-item col-lg-4">';
                    $user->picture = $user->picture!=''?$user->picture:User::$defaults['picture'];
                    $picture = RImage::styleSrc($user->picture,User::getPicOptions());
                    echo '<a href="' . RHtml::siteUrl('user/view/' . $user->id) . '">' . RHtml::image($picture,$user->name,array("width"=>"64px","height"=>"64px")). '</a>';
                    $name = $user->name;
                    if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                    echo RHtml::linkAction('user', $name, 'view', $user->id, array('title' => $user->name)) . "  ";
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix"></div>';
                echo '<span class="glyphicon glyphicon-user"></span>&nbsp;'.RHtml::linkAction('group',"All group members",'members',$groupId);
            }
        ?>
    </div>
</div>