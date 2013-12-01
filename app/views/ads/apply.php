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
    <div class="panel-heading"><b><?php if (isset($edit)) echo 'Edit Advertisement'; else echo 'Ads application'; ?></b></div>
    <div class="panel-body">
        <?=RFormHelper::openForm('ads/'.(isset($edit)?'edit/'.$ad->id.'/'.$type:'apply'),array('id'=>'applyAdsForm'))?>
        <?=RFormHelper::label('Ads title','ads-title')?>
        <?=RFormHelper::input(
            array(
                'id'=>'ads-title',
                'name'=>'ads-title',
                'class'=>'form-control',
            ), isset($form['ads-title'])?$form:(isset($edit)?$ad->title:$form))?>

        <br/>

        <?=RFormHelper::label('Ads content','ads-content')?>
        <?php
            $this->module('ckeditor',
                array(
                    'editorId'=>'ads-content',
                    'name'=>'ads-content',
                    'data'=>(isset($form['ads-content'])?$form['ads-content']:(isset($edit) ?$ad->content:''))
                ));
        ?>

        <br/>

        <?=RFormHelper::label('Paid price ('. Rays::app()->getLoginUser()->getWallet()->money ." Group Coins in your wallet)",'paid-price')?>
        <div class="input-group">
            <?=RFormHelper::input(
                array_merge(array(
                    'id'=>'paid-price',
                    'name'=>'paid-price',
                    'class'=>'form-control',
                    ),isset($edit)?['readonly' => true]:[]
                ),
                isset($form['paid-price'])?$form:(isset($edit)?$ad->paidPrice:$form))?>
            <span class="input-group-addon">Group Coins</span>
        </div>

        <br/>

        <?=RFormHelper::input(
            array(
                'type'=>'submit',
                'class'=>'btn btn-sm btn-success',
                'value'=>isset($edit)?'Save':'Send Ads application'
            ))?>

        <?=RFormHelper::endForm()?>
    </div>
</div>
