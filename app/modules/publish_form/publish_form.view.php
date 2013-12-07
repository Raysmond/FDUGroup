<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-12-7
 */
?>
<div class="panel panel-default">
    <div class="panel-body">
        <input type="hidden" id="publish_form_path" name="publish_form_path" value="<?=$path?>" />
        <input type="hidden" id="publish_form_id" name="publish_form_path" value="post-content" />

        <div class="home-actions">
            <div class="home-actions-item">
                <a href="<?=RHtmlHelper::siteUrl('group/build')?>" class="">
                    <?=RHtmlHelper::showImage('public/images/group.png','',array('width'=>'48px'))?>
                     New group</a>
            </div>

            <div class="home-actions-item">
                <a href="<?=RHtmlHelper::siteUrl('post/new')?>" class="">
                    <?=RHtmlHelper::showImage('public/images/post.png','',array('width'=>'48px'))?>
                     New post</a>

            </div>

            <div class="home-actions-item">
                <a href="<?=RHtmlHelper::siteUrl('user/find')?>" class="">
                    <?=RHtmlHelper::showImage('public/images/friend.png','',array('width'=>'48px'))?>
                     Find friends</a>
            </div>

            <div class="home-actions-item">
                <a href="<?=RHtmlHelper::siteUrl('message/send')?>" class="">
                    <?=RHtmlHelper::showImage('public/images/message.png','',array('width'=>'48px'))?>
                    New message</a>
            </div>

        </div>


<!--        --><?php //=RFormHelper::openForm('post/new',array('class'=>'quick-publish-form')) ?>
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
<!--                --><?php //=RFormHelper::input(array('type'=>'submit','class'=>'btn btn-lg btn-primary','value'=>'Publish a post'))?>
<!--            </div>-->
<!--            <div class="actions-item">-->
<!--                --><?php //=RHtmlHelper::linkAction('group','New group','build',null,array('btn btn-sm btn-info'))?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        --><?php //=RFormHelper::endForm()?>

    </div>
</div>