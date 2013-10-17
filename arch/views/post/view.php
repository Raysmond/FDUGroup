<h2><?=$topic->title?></h2>
<div>
    Post by: <?=RHtmlHelper::linkAction('user',$topic->user->name,'view',$topic->user->id) ?>
    &nbsp;&nbsp;Post in group: <?=RHtmlHelper::linkAction('group',$topic->group->name,'detail',$topic->group->id) ?>
    &nbsp;&nbsp;&nbsp;&nbsp;<?=$topic->createdTime?>
</div>

<div>
<?=RHtmlHelper::decode($topic->content)?>
</div>
<br/><br/>
<div>Actions: <?=RHtmlHelper::linkAction('post', 'Edit', 'edit', $topic->id)?></div>
<hr/>
<?php
foreach ($comments as $comment) {
?><div><?=RHtmlHelper::linkAction('user',$comment->user->name,'view',$comment->user->id)?>
    &nbsp;&nbsp;<?=$comment->createdTime?></div>
<div><?=RHtmlHelper::decode($comment->content)?></div>
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
