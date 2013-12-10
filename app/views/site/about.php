<?php
 // about view file
 // @author: Raysmond
?>
<?php
/**
 * Contact view file.
 * @author: songrenchu
 */
?>
<div class="panel panel-default">
    <div  id="developer" class="panel-heading">
        <h1 class="panel-title">About FDUGroup</h1>
    </div>

    <div class="panel-body site-hook">
        <h3>FDUGroup is the right website </h3><h4>Where you can set up or join groups and share things as you like.</h4>
        <?php
            for ($i = 1; $i <= 21; ++$i) {
                ?>
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/laugh'.$i.'.jpg'?>" style="max-height:100px;min-height:100px;" title="laugh">
                <?php
            }
        ?>

    </div>
</div>
