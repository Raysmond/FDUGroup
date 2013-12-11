<div class="panel panel-default post">
    <div class="panel-heading">
        <div class="heading-actions">
            <?php
            if ($canEdit) echo RHtmlHelper::linkAction('post', 'Edit', 'edit', $topic->id, array('class' => 'btn btn-xs btn-info'));
            ?>
        </div>
        <h1 class="panel-title"><?= $topic->title ?></h1>
    </div>

    <div class="panel-body">
        <div class="post-meta">
            <span class="glyphicon glyphicon-user"></span>
            <?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?>
            &nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>
            <?= RHtmlHelper::linkAction('group', $topic->group->name, 'detail', $topic->group->id) ?>
            &nbsp;&nbsp;
            <span class="glyphicon glyphicon-search"></span> <?= $counter->totalCount ?>
            &nbsp;&nbsp;
            <span class="glyphicon glyphicon-time"></span> <?= $topic->createdTime ?>
        </div>

        <div class="post-content">
            <?= RHtmlHelper::decode($topic->content) ?>
        </div>
        <br/><br/>

        <div class="post-rating-plus">
            <?php $this->module('rating_plus', array('entityType' => Topic::ENTITY_TYPE, 'entityId' => $topic->id)); ?>
        </div>

        <hr/>

        <div id="comments">
            <h2 class="s-title">Comments</h2>

            <?php $this->renderPartial("_comment_list", array('commentTree' => $commentTree), false); ?>

            <hr/>

            <div id="reply">
                <?= RFormHelper::openForm("post/comment/$topic->id", array('id' => 'viewFrom')) ?>
                <?=
                RFormHelper::textarea(array(
                    'name' => 'content',
                    'class' => 'form-control',
                    'rows' => '5',
                    'placeholder' => 'Comment content',
                ), isset($parent) ? '@' . $parent->user->name . ' ' : '')?>
                <?php
                if (isset($parent)) {
                    echo RFormHelper::hidden('replyTo', ((int)$parent->pid === 0 ? $parent->id : $parent->pid));
                    echo RFormHelper::hidden('exactReplyTo', $parent->id);
                }
                ?>
                <br/>
                <?= RFormHelper::input(array('class' => 'btn btn-sm btn-primary', 'type' => 'submit', 'value' => 'Comment')) ?>
                <?= RFormHelper::endForm() ?>
            </div>
        </div>

    </div>

</div>
