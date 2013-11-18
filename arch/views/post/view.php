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
foreach ($commentTree as $commentItem) {
    ?><div><?=RHtmlHelper::linkAction('user',$commentItem['root']->user->name,'view',$commentItem['root']->user->id)?>
    &nbsp;&nbsp;<?=$commentItem['root']->createdTime?></div>
    <div><?=RHtmlHelper::decode($commentItem['root']->content)?></div>
    <?=RHtmlHelper::linkAction('post','Reply','view', $commentItem['root']->topicId.'?reply='.$commentItem['root']->id)?>
    <?php
        foreach ($commentItem['reply'] as $reply) {
            ?>
            <div><?=RHtmlHelper::linkAction('user',$reply->user->name,'view',$reply->user->id)?>
                &nbsp;&nbsp;<?=$reply->createdTime?></div>
            <div><?=RHtmlHelper::decode($reply->content)?></div>
            <?php
        }
    ?>
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
),isset($parent)?'@'.$parent->user->name.' ':'')?>
<?php
if(isset($parent)){
    echo RFormHelper::hidden('replyTo',((int)$parent->pid === 0 ? $parent->id : $parent->pid));
    echo RFormHelper::hidden('exactReplyTo',$parent->id);
}
?>
<br/>
<br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => 'Comment'))?>
<?=RFormHelper::endForm()?>
