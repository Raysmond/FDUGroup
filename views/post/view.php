<div class="panel panel-default post">
    <div class="panel-heading">
        <div class="heading-actions">
            <?php
            if ($canEdit) echo RHtml::linkAction('post', 'Edit', 'edit', $topic->id, array('class' => 'btn btn-xs btn-info'));
            ?>
        </div>
        <h1 class="panel-title"><?= $topic->title ?></h1>
    </div>

    <div class="panel-body">
        <div class="post-meta">
            <span class="glyphicon glyphicon-user"></span>
            <?= RHtml::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?>
            &nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>
            <?= RHtml::linkAction('group', $topic->group->name, 'detail', $topic->group->id) ?>
            &nbsp;&nbsp;
            <span class="glyphicon glyphicon-search"></span> <?= $counter->totalCount ?>
            &nbsp;&nbsp;
            <span class="glyphicon glyphicon-time"></span> <?= $topic->createdTime ?>
        </div>

        <div class="post-content">
            <?= RHtml::decode($topic->content) ?>
        </div>
        <br/><br/>

        <div class="post-rating-plus">
            <?php $self->module('rating_plus', array('entityType' => Topic::ENTITY_TYPE, 'entityId' => $topic->id)); ?>
        </div>

        <hr/>

        <div id="comments">
            <h2 class="s-title">Comments</h2>

            <?php $self->renderPartial("_comment_list", array('commentTree' => $commentTree), false); ?>

            <hr/>

            <div id="reply">
                <?= RForm::openForm("post/comment/$topic->id", array('id' => 'viewFrom')) ?>
                <?=
                RForm::textarea(array(
                    'name' => 'content',
                    'class' => 'form-control',
                    'rows' => '5',
                    'placeholder' => 'Comment content',
                ), isset($parent) ? '@' . $parent->user->name . ' ' : '')?>
                <?php
                if (isset($parent)) {
                    echo RForm::hidden('replyTo', ((int)$parent->pid === 0 ? $parent->id : $parent->pid));
                    echo RForm::hidden('exactReplyTo', $parent->id);
                }
                ?>
                <br/>
                <?= RForm::input(array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'value' => 'Comment')) ?>
                <?= RForm::endForm() ?>
            </div>
        </div>

    </div>

</div>
