<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">
            <?php echo count($ads); ?> advertisements
            <?php echo ($type==Ads::APPLYING?"applied":""); ?>
            <?php echo ($type==Ads::BLOCKED?"blocked":""); ?>
            <?php echo ($type==Ads::APPROVED?"published":""); ?>
    </h1></div>
    <div class="panel-body">
        <div class="navbar-left">
            <?=RHtmlHelper::linkAction('ads','+ Apply','apply',null,array('class'=>'btn btn-sm btn-info'))?>
        </div>

        <div class="navbar-right">
            <?php echo RHtmlHelper::linkAction('ads',"Application",'view','applying',array('class'=>'btn btn-sm btn-default'));?>
            <?php echo RHtmlHelper::linkAction('ads',"Published",'view','published',array('class'=>'btn btn-sm btn-info'));?>
            <?php echo RHtmlHelper::linkAction('ads',"Blocked",'view','blocked',array('class'=>'btn btn-sm btn-danger'));?>
        </div>
        <div class="clearfix" style="margin-bottom: 10px;"></div>
        <?php
        foreach($ads as $ad)
        {
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div style="float:right;margin-top: -2px;">
                    <?=$ad->pubTime?>
                    &nbsp;&nbsp;&nbsp;&nbsp;Paid <?=$ad->paidPrice?> Credits&nbsp;&nbsp;
                    <?=RHtmlHelper::linkAction('ads','edit','edit',[$ad->id, $data['type']],['class' => 'btn btn-xs btn-info'])?>
                    <?=RHtmlHelper::linkAction('ads','remove','remove',[$ad->id, $data['type']],['class' => 'btn btn-xs btn-danger','onclick' => "return confirm('Are you sure to remove selected advertisement? (Removed advertisements cannot be recovered, and paid credits will not be returned.)')"])?>
                </div>
                <h3 class="panel-title">
                    <?=$ad->title?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="message-meta">
                    <?=RHtmlHelper::decode($ad->content);?>
                </div>
            </div>
        </div>
        <?php
        } if (!count($ads)) {
        ?>
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="message-meta">
                    <?php
                        if ($data['type'] == Ads::APPROVED) {
                            echo 'You don\'t have any published advertisements.';
                        } else if ($data['type'] == Ads::APPLYING) {
                            echo 'You don\'t have any applying advertisements.';
                        } else {
                            echo 'You don\'t have any blocked advertisements.';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>