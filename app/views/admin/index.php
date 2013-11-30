<?php
/**
 * Administration home page
 * @author: Raysmond
 */
?>

<div class="jumbotron">
    <h2>FDUGroup Administration</h2>
        <p>
        <?php
            date_default_timezone_set(Rays::app()->getTimeZone());
            echo Date('Y-m-d H:i:s');
        ?>
        </p>
   
    <?php ?>
</div>