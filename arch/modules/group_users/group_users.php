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
                echo '<div class="row">';
                foreach($users as $user){
                    echo '<div class="col-6 col-sm-6 col-lg-4">';
                    echo RHtmlHelper::showImage($user->picture,$user->name,array("width"=>"64px","height"=>"64px"))."<br/>";
                    echo RHtmlHelper::linkAction('user',$user->name,'view',$user->id)."  ";
                    echo '</div>';
                }
                echo '</div>';
            }
        ?>
    </div>
</div>