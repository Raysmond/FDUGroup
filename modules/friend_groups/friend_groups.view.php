<?php
/**
 * Friend groups module view
 * @author: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Friend Groups
            <?php echo (count($friends)>0?(" ( ".count($friends)." )"):''); ?>
        </h3></div>
    <div class="panel-body">
        <?php
        foreach($friends as $friend){
            echo RHtml::linkAction('group',$friend->name,'detail',$friend->id)."  ";
        }
        ?>
    </div>
    </div>