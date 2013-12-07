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

        <a href=""><span class="glyphicon glyphicon-list-alt"></span> New group</a>
<!--        --><?//=RFormHelper::openForm('post/new',array('class'=>'quick-publish-form')) ?>
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
<!--                --><?//=RFormHelper::input(array('type'=>'submit','class'=>'btn btn-lg btn-primary','value'=>'Publish a post'))?>
<!--            </div>-->
<!--            <div class="actions-item">-->
<!--                --><?//=RHtmlHelper::linkAction('group','New group','build',null,array('btn btn-sm btn-info'))?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        --><?//=RFormHelper::endForm()?>

    </div>
</div>