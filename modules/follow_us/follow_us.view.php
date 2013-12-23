<div class="panel panel-default">
    <div class="panel-heading">
        Follow us
    </div>
    <div class="panel-body" style="line-height: 300%;">
        <?=RHtml::showImage('public/images/favicon.ico','FDUGroup',array('width'=>'29px','style'=>'border-radius: 20px;margin-left: 2px;margin-right:1px;'))?>
        &nbsp;&nbsp;<b><?=RHtml::linkAction('site','About us','about')?></b>
        <br />

        <?=RHtml::showImage('public/images/info.png','FDUGroup',array('width'=>'32px'))?>
        &nbsp;&nbsp;<b><?=RHtml::linkAction('site','Contact us','contact')?></b>
        <br />

        <?php echo RHtml::showImage("public/images/github.png","FDUGroup",array('width'=>'32px')) ?>
        &nbsp;<b><a href="https://github.com/Raysmond/FDUGroup"> Follow us on Github</a></b>
        <br />

    </div>
</div>