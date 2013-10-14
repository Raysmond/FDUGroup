<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div class="jumbotron">
    <h1><font align = "left" >Hi!<?php echo " ".$user->name; ?>
    <marquee directio=left><font face=华文楷体 size=5 color = #5f9ea0>Welcome to FDUGroup ! This is your user view page,
            you can find your information in there.</font></marquee>
    </h1>
    </br>
    <p>
        <?php
        foreach($user->columns as $objCol=>$dbCol){
          ?><font color = "#2f4f4f" size = 5 face = "黑体" align = "left"> <b><?php echo $objCol; ?> </b></font>
        <font align = "left"><PRE><?php  echo $user->$objCol."<br/>";?></PRE>
         <?php   } ?>

        </font>

    </p>
</div>