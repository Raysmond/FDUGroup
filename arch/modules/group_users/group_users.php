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
                foreach($users as $user){
                    echo RHtmlHelper::linkAction('user',$user->name,'view',$user->id)."  ";
                }
            }
        ?>
    </div>
</div>