<h2><?=$topic->title?></h2>
<div>
<?=RHtmlHelper::encode($topic->content)?>
</div>
<div>Actions: <?=RHtmlHelper::linkAction('post', 'Edit', 'edit', $topic->id)?></div>
<hr/>
<?php
foreach ($comments as $comment) {
?><?=$comment->content?><br/><br/><?php
}
?>
<hr/>
<h4>Add comment</h4>
<?=RFormHelper::openForm("post/comment/$topic->id", array('id'=>'viewFrom', 'class'=>'.form-signin registerForm'))?>
<?=RFormHelper::textarea('content', '')?>
<br/>
<br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => 'Comment'))?>
<?=RFormHelper::endForm()?>
