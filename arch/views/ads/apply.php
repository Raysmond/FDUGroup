<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-23
 * Time: PM10:56
 */
?>
<div class="row" style="margin-bottom: 10px;">
    <?php
    $form = isset($applyForm)?$applyForm:array();
    if(isset($validation_errors)){
        RHtmlHelper::showValidationErrors($validation_errors);
    }
    ?>
    &nbsp;&nbsp;&nbsp;
    <?=RHtmlHelper::linkAction('ads','Back to ads','view',null,array(
        'class'=>'btn btn-xs btn-info'
    ))?>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><b>Ads application</b></div>
    <div class="panel-body">
        <?=RFormHelper::openForm('ads/apply',array('id'=>'applyAdsForm'))?>

        <?=RFormHelper::label('Ads title','ads-title')?>
        <?=RFormHelper::input(
            array(
                'id'=>'ads-title',
                'name'=>'ads-title',
                'class'=>'form-control'
            ), $form)?>

        <br/>

        <?=RFormHelper::label('Ads content','ads-content')?>
        <?php
            $this->module('ckeditor',
                array(
                    'editorId'=>'ads-content',
                    'name'=>'ads-content',
                    'data'=>(isset($form['ads-content'])?$form['ads-content']:'')
                ));
        ?>

        <br/>

        <?=RFormHelper::label('Paid price','paid-price')?>
        <div class="input-group">
            <?=RFormHelper::input(
                array(
                    'id'=>'paid-price',
                    'name'=>'paid-price',
                    'class'=>'form-control'
                ), $form)?>
            <span class="input-group-addon">RMB</span>
        </div>

        <br/>

        <?=RFormHelper::input(
            array(
                'type'=>'submit',
                'class'=>'btn btn-sm btn-success',
                'value'=>'Send Ads application'
            ))?>

        <?=RFormHelper::endForm()?>
    </div>
</div>
