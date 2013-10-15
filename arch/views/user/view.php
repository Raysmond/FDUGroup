<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div class="jumbotron">
    <div class="panel-heading">
        Hi !<?php echo " ".$user->name; ?>
    </div>

    <p>
        <?php
        foreach($user->columns as $objCol=>$dbCol){
          ?><font color = "#2f4f4f" size = 5 face = "黑体" align = "left"> <b><?php echo $objCol; ?> </b></font>
        <font align = "left"><PRE><?php  echo $user->$objCol."<br/>";?></PRE>
         <?php   } ?>

        </font>

    </p>
</div>