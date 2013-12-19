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
        <h1 class="panel-title">FDUGroup is the right website</h1>
    </div>

    <div class="panel-body site-hook">
        <h4 style="margin-bottom: 15px;">Where you can set up or join groups and share things as you like.</h4>
        <?php
            for ($i = 1; $i <= 21; ++$i) {
                ?>
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/laugh/laugh'.$i.'.jpg'?>" style="max-height:100px;min-height:100px;" title="">
                <?php
            }
        ?>
     <hr>
        "Surround yourself with good people. People who are going to be honest with you and look out for your best interests."
        <br/>
        --- Derek Jeter
        </p>
    </div>
</div>
