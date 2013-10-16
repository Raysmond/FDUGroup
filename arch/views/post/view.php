<h2><?=$topic->title?></h2>
<div>
<?=RHtmlHelper::encode($topic->content)?>
</div>
<br/><br/>
<div>Actions: <?=RHtmlHelper::linkAction('post', 'Edit', 'edit', $topic->id)?></div>
<hr/>
<?php
foreach ($comments as $comment) {
?><div><?=$comment->createdTime?></div>
<div><?=$comment->content?></div>
<br/><br/>
<?php
}
?>
<hr/>
<?=RFormHelper::openForm("post/comment/$topic->id", array('id' => 'viewFrom', 'class' => '.form-signin registerForm'))?>
<?=RFormHelper::textarea(array(
	'id' => 'content',
	'name' => 'content',
	'class' => 'form-control',
	'rows' => '5',
	'placeholder' => 'Comment',
))?>
<br/>
<br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => 'Comment'))?>
<?=RFormHelper::endForm()?>
