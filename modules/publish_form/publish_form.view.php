<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-12-7
 */
?>
<div class="panel panel-default">
    <div class="panel-body" style="margin-bottom: 0;">
        <input type="hidden" id="publish_form_path" name="publish_form_path" value="<?=$path?>" />
        <input type="hidden" id="publish_form_id" name="publish_form_path" value="post-content" />

        <div class="home-actions">
            <div class="home-actions-item">
                <a href="<?=RHtml::siteUrl('group/build')?>" class="">
                    <?=RHtml::showImage('public/images/group.png','',array('width'=>'48px'))?>
                     New group</a>
            </div>

            <div class="home-actions-item">
                <a href="<?=RHtml::siteUrl('post/new')?>" class="">
                    <?=RHtml::showImage('public/images/post.png','',array('width'=>'48px'))?>
                     New post</a>

            </div>

            <div class="home-actions-item">
                <a href="<?=RHtml::siteUrl('user/find')?>" class="">
                    <?=RHtml::showImage('public/images/friend.png','',array('width'=>'48px'))?>
                     Find friends</a>
            </div>

            <div class="home-actions-item">
                <a href="<?=RHtml::siteUrl('message/send')?>" class="">
                    <?=RHtml::showImage('public/images/message.png','',array('width'=>'48px'))?>
                    New message</a>
            </div>

        </div>


<!--        --><?php //=RForm::openForm('post/new',array('class'=>'quick-publish-form')) ?>
        <?php
//        Rays::app()->getController()->module('ckeditor',
//            array('editorId'=>'post-content',
//                'name'=>'content',
//                'data'=>"",
//                'editorClass' => 'quick-publish-form',
//                'customInitialJs'=>$initJs
//            ));
//        ?>
<!---->
<!--        <div class="actions">-->
<!--            <div class="actions-item">-->
<!--                --><?php //=RForm::input(array('type'=>'submit','class'=>'btn btn-lg btn-primary','value'=>'Publish a post'))?>
<!--            </div>-->
<!--            <div class="actions-item">-->
<!--                --><?php //=RHtml::linkAction('group','New group','build',null,array('btn btn-sm btn-info'))?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        --><?php //=RForm::endForm()?>

    </div>
</div>