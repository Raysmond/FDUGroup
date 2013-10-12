<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>
<div class="jumbotron">
    <h1><?php echo $user->name; ?></h1>
    <p>
        <?php
        foreach($user->columns as $objCol=>$dbCol){
            echo $objCol.": ".$user->$objCol."<br/>";
        }
        ?>
    </p>
</div>