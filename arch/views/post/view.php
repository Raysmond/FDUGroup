<div class="post">
    <h2><?= $topic->title ?></h2>

    <div class="post-meta">
        Post by:
        <?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?>
        &nbsp;&nbsp;Post in
        group: <?= RHtmlHelper::linkAction('group', $topic->group->name, 'detail', $topic->group->id) ?>
        &nbsp;&nbsp;<?= $counter->totalCount ?> reads
        &nbsp;&nbsp;<?= $topic->createdTime ?>
    </div>

    <div class="post-content row">
        <?= RHtmlHelper::decode($topic->content) ?>
    </div>
    <br/><br/>

    <div>
        Actions: <?= RHtmlHelper::linkAction('post', 'Edit', 'edit', $topic->id, array('class' => 'btn btn-xs btn-info')) ?></div>
</div>
    <hr/>

<h2>Comments</h2>
<?php
foreach ($commentTree as $commentItem) {
    ?>
    <div id="comment-item-<?= $commentItem['root']->id ?>" class="row comment-item">
    <!-- user picture -->
    <div
        class="col-lg-1"><?= RHtmlHelper::showImage($commentItem['root']->user->picture, $commentItem['root']->user->name, array('width' => '64px;')) ?></div>

    <!-- comment content -->
    <div class="col-lg-11">
        <div><?= RHtmlHelper::linkAction('user', $commentItem['root']->user->name, 'view', $commentItem['root']->user->id) ?>
            &nbsp;&nbsp;<?= $commentItem['root']->createdTime ?></div>
        <div><?= RHtmlHelper::decode($commentItem['root']->content) ?></div>

        <div style="float: right;">
        <?= RHtmlHelper::linkAction('post', 'Reply', 'view', $commentItem['root']->topicId . '?reply=' . $commentItem['root']->id.'#reply',array('class' => 'btn btn-xs btn-info')) ?>
        </div>

        <?php
        foreach ($commentItem['reply'] as $reply) {
            ?>
            <div><?= RHtmlHelper::linkAction('user', $reply->user->name, 'view', $reply->user->id) ?>
                &nbsp;&nbsp;<?= $reply->createdTime ?></div>
            <div><?= RHtmlHelper::decode($reply->content) ?></div>
        <?php
        }
        ?>
    </div>
    <br/><br/>
    </div>
    <hr>
<?php
}
?>


<hr/>
<div id="reply">
<?= RFormHelper::openForm("post/comment/$topic->id", array('id' => 'viewFrom', 'class' => '.form-signin registerForm')) ?>
<?=
RFormHelper::textarea(array(
    'id' => 'content',
    'name' => 'content',
    'class' => 'form-control',
    'rows' => '5',
    'placeholder' => 'Comment',
), isset($parent) ? '@' . $parent->user->name . ' ' : '')?>
<?php
if (isset($parent)) {
    echo RFormHelper::hidden('replyTo', ((int)$parent->pid === 0 ? $parent->id : $parent->pid));
    echo RFormHelper::hidden('exactReplyTo', $parent->id);
}
?>
<br/>
<br/>
<?= RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => 'Comment')) ?>
<?= RFormHelper::endForm() ?>
    </div>
